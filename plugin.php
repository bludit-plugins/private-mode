<?php

class PrivateModePlugin extends Plugin
{

    public function init()
    {
        $this->dbFields = array(
            'enable' => true,
            'message' => 'Private Access Only'
        );
    }

    public function form()
    {
        global $L;

        $html  = '<div>';
        $html .= '<label>' . $L->get('enable-private-mode') . '</label>';
        $html .= '<select name="enable">';
        $html .= '<option value="true" ' . ($this->getValue('enable') === true ? 'selected' : '') . '>Enabled</option>';
        $html .= '<option value="false" ' . ($this->getValue('enable') === false ? 'selected' : '') . '>Disabled</option>';
        $html .= '</select>';
        $html .= '</div>';

        $html .= '<div>';
        $html .= '<label>' . $L->get('message') . '</label>';
        $html .= '<input name="message" id="jsmessage" type="text" value="' . $this->getValue('message') . '">';
        $html .= '</div>';

        return $html;
    }

    public function beforeAll()
    {
        if ($this->getValue('enable')) {
            /**
             * 302 Redirect to admin if not logged in.
             */
            $login = new Login();
            if (! $login->isLogged()) {
                Alert::set($this->getValue('message'));
                Redirect::url(DOMAIN_ADMIN);
            }
        }
    }
}
