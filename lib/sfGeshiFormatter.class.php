<?php
/**
 * simple Geshi - Symfony  Wrapper class
 *
 * this class needs pecl extension bbcode http://de3.php.net/manual/en/book.bbcode.php
 * and geshi http://qbnz.com/highlighter/
 *
 * @author Robert Schönthal caziel[at]gmx[dot]net
 */

include (dirname(__FILE__)."/vendor/geshi/geshi.php");

class sfGeshiFormatter {

  /**
   * formats a piece of code with the given language
   *
   * @param <string> $code
   * @param <string> $lang
   * @return <string>
   */
  public static function format($code,$lang) {
    try {
      $geshi = new GeSHi($code,$lang);
      $geshi->enable_classes(true);
      $geshi->enable_line_numbers(GESHI_NORMAL_LINE_NUMBERS);
      $newcode = $geshi->parse_code();
      $newcode .="<style type='text/css'>".$geshi->get_stylesheet()."</style>";
    }catch(Exception $e ){
      return $code;
    }
    return $newcode;
  }

  /**
   * search n replace code blocks
   * @param <string> $text
   * @return <string>
   */
  public static function replace($text) {
    $blocks = array();
    $codes=array(
        'code'=>      array('type'=>BBCODE_TYPE_ARG,
        'open_tag'=>'<pre class="{PARAM}">', 'close_tag'=>'</pre>',
        'default_arg'=>'{PARAM}',
        'content_handling'=>array('sfGeshiFormatter','format')
        )
    );

    try {
      $BBHandler=bbcode_create($codes);

      $newtext = bbcode_parse($BBHandler,$text);

    }catch(Exception $e ){
      return $text;
    }

    return $newtext;
  }

}