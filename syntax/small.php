<?php

/**
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Michal Červeňák <miso@fykos.cz>
 */
// must be run within Dokuwiki
if(!defined('DOKU_INC')){
    die();
}

class syntax_plugin_fkshelper_small extends DokuWiki_Syntax_Plugin {

    public function getType() {
        return 'formatting';
    }

    public function getPType() {
        return 'normal';
    }

    public function getAllowedTypes() {
        return ['formatting'];
    }

    public function getSort() {
        return 10;
    }

    public function connectTo($mode) {
        $this->Lexer->addEntryPattern('<small>(?=.*?</small>)',$mode,'plugin_fkshelper_small');
    }

    public function postConnect() {
        $this->Lexer->addExitPattern('</small>','plugin_fkshelper_small');
    }

    /**
     * Handle the match
     */
    public function handle($match,$state) {
        if($state == DOKU_LEXER_UNMATCHED){
            return [$state, $match];
        }

        return [$state];
    }

    public function render($mode,Doku_Renderer &$renderer,$data) {
        if($mode == 'xhtml'){
            list($state,$payload) = $data;
            switch ($state) {
                case DOKU_LEXER_ENTER :
                    $renderer->doc .= '<small>';
                    break;
                case DOKU_LEXER_MATCHED :
                    break;
                case DOKU_LEXER_UNMATCHED :
                    $renderer->doc .= $renderer->_xmlEntities($payload);
                    break;
                case DOKU_LEXER_EXIT :
                    $renderer->doc .= '</small>';
                    break;
                case DOKU_LEXER_SPECIAL :
                    break;
            }

            return true;
        }else{
            return false;
        }
    }

}
