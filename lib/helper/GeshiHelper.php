<?php

  /**
   * replaces all [code=lang][/code] tags with styled markup
   * @param <string> $text
   * @return <string>
   */
  function geshi_beautify($text){
    return sfGeshiFormatter::replace($text);
  }

