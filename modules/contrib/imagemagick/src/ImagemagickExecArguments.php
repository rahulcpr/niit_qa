<?php

namespace Drupal\imagemagick;

/**
 * Stores arguments for execution of ImageMagick/GraphicsMagick commands.
 */
class ImagemagickExecArguments {

  /**
   * Default index for adding arguments.
   */
  const APPEND = -1;

  /**
   * Mode for arguments to be placed before the source path.
   */
  const PRE_SOURCE = 0;

  /**
   * Mode for arguments to be placed after the source path.
   */
  const POST_SOURCE = 1;

  /**
   * Mode for arguments not to be placed on the command line.
   */
  const INTERNAL = 2;

  /**
   * The ImageMagick execution manager service.
   *
   * @var \Drupal\imagemagick\ImagemagickExecManagerInterface
   */
  protected $execManager;

  /**
   * The array of command line arguments to be used by 'convert'.
   *
   * @var string[]
   */
  protected $arguments = [];

  /**
   * Path of the image file.
   *
   * @var string
   */
  protected $source = '';

  /**
   * The local filesystem path to the source image file.
   *
   * @var string
   */
  protected $sourceLocalPath = '';

  /**
   * The source image format.
   *
   * @var string
   */
  protected $sourceFormat = '';

  /**
   * The source image frames to access.
   *
   * @var string
   */
  protected $sourceFrames;

  /**
   * The image destination URI/path on saving.
   *
   * @var string
   */
  protected $destination = NULL;

  /**
   * The local filesystem path to the image destination.
   *
   * @var string
   */
  protected $destinationLocalPath = '';

  /**
   * The image destination format on saving.
   *
   * @var string
   */
  protected $destinationFormat = '';

  /**
   * Constructs an ImagemagickExecArguments object.
   *
   * @param \Drupal\imagemagick\ImagemagickExecManagerInterface $exec_manager
   *   The ImageMagick execution manager service.
   */
  public function __construct(ImagemagickExecManagerInterface $exec_manager) {
    $this->execManager = $exec_manager;
  }

  /**
   * Gets a portion of the command line arguments string.
   *
   * @param int $mode
   *   The mode of the string on the command line. Can be self::PRE_SOURCE or
   *   self::POST_SOURCE.
   *
   * @return string
   *   The sring of command line arguments.
   */
  public function toString(int $mode): string {
    if (!$this->arguments) {
      return '';
    }
    $ret = [];
    foreach ($this->arguments as $a) {
      if ($a['mode'] === $mode) {
        $ret[] = $a['argument'];
      }
    }
    return implode(' ', $ret);
  }

  /**
   * Adds a command line argument.
   *
   * @param string $argument
   *   The command line argument to be added.
   * @param int $mode
   *   (optional) The mode of the argument in the command line. Determines if
   *   the argument should be placed before or after the source image file path.
   *   Defaults to self::POST_SOURCE.
   * @param int $index
   *   (optional) The position of the argument in the arguments array.
   *   Reflects the sequence of arguments in the command line. Defaults to
   *   self::APPEND.
   * @param array $info
   *   (optional) An optional array with information about the argument.
   *   Defaults to an empty array.
   *
   * @return $this
   */
  public function add(string $argument, int $mode = self::POST_SOURCE, int $index = self::APPEND, array $info = []): ImagemagickExecArguments {
    $argument = [
      'argument' => $argument,
      'mode' => $mode,
      'info' => $info,
    ];
    if ($index === self::APPEND) {
      $this->arguments[] = $argument;
    }
    elseif ($index === 0) {
      array_unshift($this->arguments, $argument);
    }
    else {
      array_splice($this->arguments, $index, 0, [$argument]);
    }
    return $this;
  }

  /**
   * Returns an array of the indexes of arguments matching specific criteria.
   *
   * @param string $regex
   *   The regular expression pattern to be matched in the argument.
   * @param int $mode
   *   (optional) If set, limits the search to the mode of the argument.
   *   Defaults to NULL.
   * @param array $info
   *   (optional) If set, limits the search to the arguments whose $info array
   *   key/values match the key/values specified. Defaults to an empty array.
   *
   * @return array
   *   Returns an array with the matching arguments.
   */
  public function find(string $regex, int $mode = NULL, array $info = []): array {
    $ret = [];
    foreach ($this->arguments as $i => $a) {
      if ($mode !== NULL && $a['mode'] !== $mode) {
        continue;

      }
      if (!empty($info)) {
        $intersect = array_intersect($info, $a['info']);
        if ($intersect != $info) {
          continue;

        }
      }
      if (preg_match($regex, $a['argument']) === 1) {
        $ret[$i] = $a;
      }
    }
    return $ret;
  }

  /**
   * Removes a command line argument.
   *
   * @param int $index
   *   The index of the command line argument to be removed.
   *
   * @return $this
   */
  public function remove(int $index): ImagemagickExecArguments {
    if (isset($this->arguments[$index])) {
      unset($this->arguments[$index]);
    }
    return $this;
  }

  /**
   * Resets the command line arguments.
   *
   * @return $this
   */
  public function reset(): ImagemagickExecArguments {
    $this->arguments = [];
    return $this;
  }

  /**
   * Sets the path of the source image file.
   *
   * @param string $source
   *   The source path of the image file.
   *
   * @return $this
   */
  public function setSource(string $source): ImagemagickExecArguments {
    $this->source = $source;
    return $this;
  }

  /**
   * Gets the path of the source image file.
   *
   * @return string
   *   The source path of the image file, or an empty string if the source is
   *   not set.
   */
  public function getSource(): string {
    return $this->source;
  }

  /**
   * Sets the local filesystem path to the image file.
   *
   * @param string $path
   *   A filesystem path.
   *
   * @return $this
   */
  public function setSourceLocalPath(string $path): ImagemagickExecArguments {
    $this->sourceLocalPath = $path;
    return $this;
  }

  /**
   * Gets the local filesystem path to the image file.
   *
   * @return string
   *   A filesystem path.
   */
  public function getSourceLocalPath(): string {
    return $this->sourceLocalPath;
  }

  /**
   * Sets the source image format.
   *
   * @param string $format
   *   The image format.
   *
   * @return $this
   */
  public function setSourceFormat(string $format): ImagemagickExecArguments {
    $this->sourceFormat = $this->execManager->getFormatMapper()->isFormatEnabled($format) ? $format : '';
    return $this;
  }

  /**
   * Sets the source image format from an image file extension.
   *
   * @param string $extension
   *   The image file extension.
   *
   * @return $this
   */
  public function setSourceFormatFromExtension(string $extension): ImagemagickExecArguments {
    $this->sourceFormat = $this->execManager->getFormatMapper()->getFormatFromExtension($extension) ?: '';
    return $this;
  }

  /**
   * Gets the source image format.
   *
   * @return string
   *   The source image format.
   */
  public function getSourceFormat(): string {
    return $this->sourceFormat;
  }

  /**
   * Sets the source image frames to access.
   *
   * @param string $frames
   *   The frames in '[n]' string format.
   *
   * @return $this
   *
   * @see http://www.imagemagick.org/script/command-line-processing.php
   */
  public function setSourceFrames(string $frames): ImagemagickExecArguments {
    $this->sourceFrames = $frames;
    return $this;
  }

  /**
   * Gets the source image frames to access.
   *
   * @return string|null
   *   The frames in '[n]' string format.
   *
   * @see http://www.imagemagick.org/script/command-line-processing.php
   */
  public function getSourceFrames() {
    return $this->sourceFrames;
  }

  /**
   * Sets the image destination URI/path on saving.
   *
   * @param string $destination
   *   The image destination URI/path.
   *
   * @return $this
   */
  public function setDestination(string $destination): ImagemagickExecArguments {
    $this->destination = $destination;
    return $this;
  }

  /**
   * Gets the image destination URI/path on saving.
   *
   * @return string
   *   The image destination URI/path.
   */
  public function getDestination(): string {
    return $this->destination;
  }

  /**
   * Sets the local filesystem path to the destination image file.
   *
   * @param string $path
   *   A filesystem path.
   *
   * @return $this
   */
  public function setDestinationLocalPath(string $path): ImagemagickExecArguments {
    $this->destinationLocalPath = $path;
    return $this;
  }

  /**
   * Gets the local filesystem path to the destination image file.
   *
   * @return string
   *   A filesystem path.
   */
  public function getDestinationLocalPath(): string {
    return $this->destinationLocalPath;
  }

  /**
   * Sets the image destination format.
   *
   * When set, it is passed to the convert binary in the syntax
   * "[format]:[destination]", where [format] is a string denoting an
   * ImageMagick's image format.
   *
   * @param string $format
   *   The image destination format.
   *
   * @return $this
   */
  public function setDestinationFormat(string $format): ImagemagickExecArguments {
    $this->destinationFormat = $format;
    return $this;
  }

  /**
   * Sets the image destination format from an image file extension.
   *
   * When set, it is passed to the convert binary in the syntax
   * "[format]:[destination]", where [format] is a string denoting an
   * ImageMagick's image format.
   *
   * @param string $extension
   *   The destination image file extension.
   *
   * @return $this
   */
  public function setDestinationFormatFromExtension(string $extension): ImagemagickExecArguments {
    $this->destinationFormat = $this->execManager->getFormatMapper()->getFormatFromExtension($extension) ?: '';
    return $this;
  }

  /**
   * Gets the image destination format.
   *
   * When set, it is passed to the convert binary in the syntax
   * "[format]:[destination]", where [format] is a string denoting an
   * ImageMagick's image format.
   *
   * @return string
   *   The image destination format.
   */
  public function getDestinationFormat(): string {
    return $this->destinationFormat;
  }

  /**
   * Escapes a string.
   *
   * @param string $argument
   *   The string to escape.
   *
   * @return string
   *   An escaped string for use in the
   *   ImagemagickExecManagerInterface::execute method.
   */
  public function escape(string $argument): string {
    return $this->execManager->escapeShellArg($argument);
  }

}
