vcl 4.0;

import std;

backend default {
  .host                   = "10.10.9.80";
  .port                   = "80";
  .connect_timeout        = 600s;
  .first_byte_timeout     = 600s;
  .between_bytes_timeout  = 600s;
}

# Access control list for specific requests like PURGE.
# Here you need to put the IP address of your web server.
acl internal {
  "127.0.0.1";
  "10.10.9.80";
  "10.10.9.83";
  "10.10.9.1";
  "172.18.0.3";
}

# Respond to incoming requests.
sub vcl_recv {

  # Cache invalidation support:
  #
  #  1. ENTIRE SITE (200):
  #     - method: BAN
  #     - path: /site
  #     - header X-Varnish-Purge: site secret (MUST match X-Varnish-Secret value).
  #  2. CACHE TAGS (200):
  #     - method: BAN
  #     - path: /tags
  #     - header X-Varnish-Purge: site secret (MUST match X-Varnish-Secret value).
  #     - header X-Tag: 32f5 de19 143b - hashed version of the tag to invalidate
  #  3. DEFLATE CALL (200):
  #     - method: BAN
  #     - path: /deflate
  #     - header X-Varnish-Purge: site secret (MUST match X-Varnish-Secret value).
  #  4. SINGLE URL + VARIANTS (200):
  #     - method: BAN
  #     - path: (the path to invalidate, e.g.: "path/a?p=1" or "path/*")
  #     - header Host: the hostname to clear the path for.
  #     - header X-Varnish-Purge: site secret (no verification)
  if (req.method == "BAN") {
    if (!req.http.X-Varnish-Purge) {
      return (synth(405, "Permission denied."));
    }
    if (!client.ip ~ internal) {
      return (synth(405, "Permission denied."));
    }
    set req.http.X-Varnish-Purge = std.tolower(req.http.X-Varnish-Purge);
    if (req.url == "/site") {
      ban("obj.http.X-Varnish-Secret == " + req.http.X-Varnish-Purge);
      return (synth(200, "Site banned."));
    }
    else if ((req.url == "/tags") && req.http.X-Tag) {
      set req.http.X-Tag = "(^|\s)" + regsuball(std.tolower(req.http.X-Tag), "\ ", "(\\s|$)|(^|\\s)") + "(\s|$)";
      ban("obj.http.X-Varnish-Secret == " + req.http.X-Varnish-Purge + " && obj.http.X-Tag ~ " + req.http.X-Tag);
      return (synth(200, "Tags banned."));
    }
    else if (req.url == "/deflate") {
      ban("obj.http.ETag ~ .{8}" + req.http.X-Deflate-Tag + " && obj.http.X-Deflate-Key != " + req.http.X-Deflate-Key);
      return (synth(200, "Deflate operation performed."));
    }
    else {
      set req.url = std.tolower(req.url);
      if (req.url ~ "\*") {
        set req.url = regsuball(req.url, "\*", "\.*");
        ban("obj.http.X-Varnish-Secret == " + req.http.X-Varnish-Purge + " && obj.http.X-Url ~ ^" + req.url + "$");
        return (synth(200, "WILDCARD URL banned."));
      }
      else {
        ban("obj.http.X-Varnish-Secret == " + req.http.X-Varnish-Purge + " && obj.http.X-Url ~ " + req.url);
        return (synth(200, "URL banned."));
      }
    }
  }

  unset req.http.X-Real-Forwarded-For;
  set   req.http.X-Real-Forwarded-For = client.ip;
  unset req.http.X-Varnish-Client-IP;
  set   req.http.X-Varnish-Client-IP = client.ip;

  set req.url = std.querysort(req.url);

  if (!req.method ~ "BAN|PURGE|GET|HEAD|PUT|POST|TRACE|OPTIONS|DELETE") {
    return(synth(400, "Bad request"));
  }

  if (req.url ~ "^/(cron|install|update)\.php") {
    return(synth(403, "Forbidden"));
  }

  if (req.method != "GET" && req.method != "HEAD") {
    return (pass);
  }

  if (req.http.Upgrade ~ "(?i)websocket") {
    return (pipe);
  }

  if (req.url ~ "^/(cron|install|update)\.php") {
    if (!client.ip ~ internal) {
      return(synth(403, "Forbidden"));
    }
    return(pass);
  }

  if (req.url ~ "(?i)\.(twig|yml|module|info|inc|profile|engine|test|po|txt|theme|svn|git|tpl(\.php)?)(\?.*|)$"
  && !req.url ~ "(?i)robots\.txt"
  ) {
    if (!client.ip ~ internal) {
      return(synth(403, "Forbidden"));
    }
  }

  # Pass Caching if it was requested from backend.
  if (req.http.X-Pass-Varnish) {
    set req.http.X-Pass-Varnish = "YES";
    return(pass);
  }

  if (req.url ~ "\.(jpeg|jpg|png|gif|ico|swf|js|css|txt|eot|woff|ttf|htc)(\?.*|)$") {
    unset req.http.Cookie;
    return (hash);
  }

  if (req.url ~ "\.(webm|mp3|m4a|mp4|m4v|mov|mpeg|mpg|avi|divx|ogg|ogv|wma|pdf|tar|gz|gzip|bz2)(\?.*|)$") {
    unset req.http.Cookie;
    return(pipe);
  }

  if ((req.url ~ "/system/ajax/") && (! req.url ~ "/cached")) {
    return(pass);
  }

  if (req.url ~ "/user"
   || req.url ~ "/admin"
   || req.url ~ "/u/"
   || req.url ~ "/p/"
   || req.url ~ "/no_cache/"
  ) {
    return(pass);
  }

  if (
     req.url ~ "^/sites/.*/files/"
  || req.url ~ "^/sites/all/themes/"
  || req.url ~ "^/modules/.*\.(js|css)\?"
  ) {
    unset req.http.Cookie;
  }

  return (hash);
}

sub vcl_hash {

    /** Default hash */
    hash_data(req.url);
    hash_data(req.http.host);

    /** Place ajax into separate bin. */
    hash_data(req.http.X-Requested-With);

    /** Add protocol if available. */
    hash_data(req.http.X-Forwarded-Proto);

    /** Process authenticated users */
    if (req.http.Cookie ~ "^(|.*; ?)S?SESS([a-z0-9]{32}=[^;]+)(;.*|)$") {

        /** Extraxt full session value */
        set req.http.X-SESS = regsub(req.http.Cookie, "^(|.*; ?)S?SESS([a-z0-9]{32}=[^;]+)(;.*|)$", "\2");

        # Get Cookie Bin. And Set new header for Vary caching.
        if (req.http.Cookie ~ "^(|.*; ?)ADVBIN=([^;]+)(;.*|)$") {
          set req.http.X-Bin  = "role:" + regsub(req.http.Cookie, "^(|.*; ?)ADVBIN=([^;]+)(;.*|)$", "\2");
        }

        /** ESI_CACHEMODE_1 - SHARED */
        if (req.url ~ "/adv_varnish/esi/" && req.url ~ "[\?&]cachemode=1(&|$)") {
            set req.http.X-Bin = "role:anonymous";
        }

        /** ESI_CACHEMODE_2 - ROLE */
        /** X-Bin role:...         */
        /** This is default behavior User role will be set as cookie bin at the beginning of this condition. */

        /** ESI_CACHEMODE_3 - USER */
        if (req.url ~ "/adv_varnish/esi/" && req.url ~ "[\?&]cachemode=3(&|$)") {
            /** Set user session as bin */
            set req.http.X-Bin  = "user:" + req.http.X-SESS;
        }
        set req.http.X-URL = req.url;
    }
    else {
      set req.http.X-Bin = "role:anonymous";
    }

    /** If Bin is set - add it to hash data for this page */
    hash_data(req.http.X-Bin);

    return (lookup);
}


# Instruct Varnish what to do in the case of certain backend responses (beresp).
sub vcl_backend_response {

   /** Enable ESI if requested on this page */
   if (beresp.http.X-DOESI) {
     set beresp.do_esi = true;
     /** Avoid cache onn Browser side */
     unset beresp.http.ETag;
     unset beresp.http.Last-Modified;
   }

  /** compression, vcl_miss/vcl_pass unset compression from the backend */
  if ( ! beresp.http.Content-Encoding && (
     beresp.http.content-type ~ "text"
  || beresp.http.content-type ~ "application/xml"
  || beresp.http.content-type ~ "application/xml\+rss"
  || beresp.http.content-type ~ "application/rss\+xml"
  || beresp.http.content-type ~ "application/xhtml+xml"
  || beresp.http.content-type ~ "application/x-javascript"
  || beresp.http.content-type ~ "application/javascript"
  || beresp.http.content-type ~ "application/json"
  || beresp.http.content-type ~ "font/truetype"
  || beresp.http.content-type ~ "application/x-font-ttf"
  || beresp.http.content-type ~ "application/x-font-opentype"
  || beresp.http.content-type ~ "font/opentype"
  || beresp.http.content-type ~ "application/vnd\.ms-fontobject"
  || beresp.http.content-type ~ "image/svg\+xml"
  || beresp.http.content-type ~ "image/x-icon"
  ))  {
   set beresp.do_gzip = true;
  }

  # Set ban-lurker friendly custom headers.
  set beresp.http.X-Url = bereq.url;
  set beresp.http.X-Host = bereq.http.host;

  # Cache 404s, 301s, at 500s with a short lifetime to protect the backend.
  if (beresp.status == 404 || beresp.status == 301 || beresp.status == 500) {
    set beresp.ttl = 10m;
  }

  # Don't allow static files to set cookies.
  # (?i) denotes case insensitive in PCRE (perl compatible regular expressions).
  # This list of extensions appears twice, once here and again in vcl_recv so
  # make sure you edit both and keep them equal.
  if (bereq.url ~ "(?i)\.(jpeg|jpg|png|gif|ico|swf|js|css|txt|eot|woff|ttf|htc|mp3|m4a|mp4|m4v|mov|mpeg|mpg|avi|divx|ogg|ogv|wma|pdf|tar|gz|gzip|bz2|asc|dat|doc|xls|ppt|tgz|csv)(\?.*|)$") {
    unset beresp.http.set-cookie;
    return(deliver);
  }

  # Allow items to remain in cache up to X hours past their cache expiration.
  set beresp.grace = std.duration(beresp.http.X-Grace + "s", 0s);

  # Use ttl from X-TTL header. If X-Adv-Varnish header exists (page created by Drupal) and
  # missing X-Drupal-[Dynamic-]Cache headers, then the page should not be cached for some
  # reason (Page-Cache-Kill-Switch, Vary per User or Session etc)
  set beresp.ttl = std.duration(beresp.http.X-TTL + "s", 0s);
  if (bereq.url !~ "/adv_varnish/esi/"  &&
      beresp.http.X-Adv-Varnish == "Cache-Enabled" &&
      beresp.http.X-Drupal-Dynamic-Cache != "MISS" &&
      beresp.http.X-Drupal-Dynamic-Cache != "HIT" &&
      beresp.http.X-Drupal-Cache != "HIT" &&
      beresp.http.X-Drupal-Cache != "MISS") {
      set beresp.ttl = 0s;
  }

  if (beresp.http.Set-Cookie) {
    set beresp.http.X-Cacheable = "NO:Cookie in the response";
    set beresp.ttl = 0s;
  }
  elsif (beresp.ttl <= 0s) {
    set beresp.http.X-Cacheable = "NO:Not Cacheable";
  }
  elsif (beresp.http.Cache-Control ~ "private" && !beresp.http.X-DOESI) {
    set beresp.http.X-Cacheable = "NO:Cache-Control=private";
    set beresp.uncacheable = true;
  }
  else {
    set beresp.http.X-Cacheable = "YES";
  }

  if (beresp.ttl > 0s) {
    unset beresp.http.Set-Cookie;
  }
  set beresp.http.X-Varnish-Secret = std.tolower(beresp.http.X-Varnish-Secret);

  set beresp.http.X-TTL2 = beresp.ttl;

  # Disable buffering only for BigPipe responses
  if (beresp.http.Surrogate-Control ~ "BigPipe/1.0") {
    set beresp.do_stream = true;
    set beresp.ttl = 0s;
  }
}



# Set a header to track a cache HITs and MISSes.
sub vcl_deliver {

  # If the header doesn't already exist, set it.
  #if (!req.http.X-Bin) {
  #set resp.http.X-Bin = "role:anonymous";
  #}
  set resp.http.X-Bin = req.http.X-Bin;

  if (obj.hits > 0) {
    set resp.http.X-Varnish-Cache = "HIT";
    set resp.http.X-Cache-TTL-Remaining = req.http.X-Cache-TTL-Remaining;

    if (resp.http.Age) {
      set resp.http.X-Cache-Age = resp.http.Age;
    }
  }
  else {
    set resp.http.X-Varnish-Cache = "MISS";
  }

  set resp.http.X-Cache-Hits = obj.hits;

  # If it's a Drupal-Page with X-Bin vary, tell browsers to vary by Cookie.
  if (resp.http.Vary ~ "X-Bin") {
    set resp.http.Vary = resp.http.Vary + ", Cookie";
  }

  # Remove ban-lurker friendly custom headers when delivering to client.
  if (!resp.http.X-Cache-Debug) {
    unset resp.http.X-Url;
    unset resp.http.X-Host;
    unset resp.http.Purge-Cache-Tags;
    unset resp.http.X-Drupal-Cache-Contexts;
    unset resp.http.X-Drupal-Cache-Tags;
    unset resp.http.X-Drupal-Dynamic-Cache;
    unset resp.http.X-Bin;
    unset resp.http.X-Tag;
    unset resp.http.X-TTL2;
    unset resp.http.X-Cache-TTL;
    unset resp.http.X-Powered-By;
    unset resp.http.Via;
    unset resp.http.X-Generator;
    unset resp.http.Connection;
    unset resp.http.Server;
    unset resp.http.X-DOESI;
    unset resp.http.X-Varnish-Secret;
    unset resp.http.X-Deflate-Key;
  }

  return (deliver);
}

# Right after an object has been found (hit) in the cache.
sub vcl_hit {
  set req.http.X-Cache-TTL-Remaining = obj.ttl;

  if (obj.ttl >= 0s) {
    return (deliver);
  }

  if (std.healthy(req.backend_hint)) {
    if (obj.ttl + 10s > 0s) {
      return (deliver);
    } else {
      return(deliver);
    }
  } else {

      if (obj.ttl + obj.grace > 0s) {
        return (deliver);
      } else {
        return (deliver);
      }
  }

  return (deliver);
}

# Right after an object was looked up and not found in cache.
sub vcl_miss {
  return (fetch);
}

# Run after a pass in vcl_recv OR after a lookup that returned a hitpass.
sub vcl_pass {
  # stub
}

sub vcl_pipe {
  if (req.http.upgrade) {
    set bereq.http.upgrade = req.http.upgrade;
  }
  set bereq.http.connection = "close";
}

sub vcl_synth {

  if (resp.status == 400) {
    set resp.status = 400;
    set resp.http.Content-Type = "text/html; charset=utf-8";

    synthetic ({"
    <?xml version="1.0" encoding="utf-8"?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
    <html>
    <head>
    <title>400 Bad request</title>
    </head>
    <body>
    <h1>Error 400 Bad request</h1>
    <p>Bad request</p>
    </body>
    </html>
    "});

    return(deliver);
  }

  if (resp.status == 401) {
    set resp.status = 401;
    set resp.http.Content-Type = "text/html; charset=utf-8";
    set resp.http.WWW-Authenticate = "Basic realm=Authentication required. Please login";

    synthetic ({"
    <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
    <HTML>
    <HEAD>
    <TITLE>Error</TITLE>
    <META HTTP-EQUIV='Content-Type' CONTENT='text/html;'>
    </HEAD>
    <BODY><H1>401 Unauthorized.</H1></BODY>
    </HTML>
    "});

    return(deliver);
  }

  if (resp.status == 403) {
    set resp.status = 403;
    set resp.http.Content-Type = "text/html; charset=utf-8";

    synthetic ({"
    <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
    <HTML>
    <HEAD>
    <TITLE>403 Forbidden</TITLE>
    <META HTTP-EQUIV='Content-Type' CONTENT='text/html;'>
    </HEAD>
    <BODY><H1>Forbidden</H1></BODY>
    <p>You don't have permissions to access "} + req.url + {" on this server</p>
    </HTML>
    "});
    return(deliver);
  }

}

sub vcl_fini {
  return (ok);
}
