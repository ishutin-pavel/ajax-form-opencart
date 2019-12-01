<?php

  public function send_form() {

    $json = array();

    if ($this->request->server['REQUEST_METHOD'] == 'POST') {
      if ((utf8_strlen($this->request->post['phone']) < 6) || (utf8_strlen($this->request->post['phone']) > 2500)) {
          $json['error'] = 'Введите Ваш телефон';
      }
      /* if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 2500)) { */
      /*   $json['error'] = 'Введите Ваше имя'; */
      /* } */
      $text = '';
      if (!isset($json['error'])) {
        //send form
        if( !$this->request->post['name']) $this->request->post['name'] = 'Аноним';
        $html = '<h3>Письмо от '.$this->request->post['name'].'</h3>';
        if($this->request->post['name'])$html .= '<p><b>Имя:</b> '.$this->request->post['name'].'</p>';
        $html .= '<p><b>Телефон:</b> '.$this->request->post['phone'].'</p>';
        $mail = new Mail(); 
        $mail->protocol = $this->config->get('config_mail_protocol');
        $mail->parameter = $this->config->get('config_mail_parameter');
        $mail->hostname = $this->config->get('config_smtp_host');
        $mail->username = $this->config->get('config_smtp_username');
        $mail->password = $this->config->get('config_smtp_password');
        $mail->port = $this->config->get('config_smtp_port');
        $mail->timeout = $this->config->get('config_smtp_timeout');			
        $mail->setTo($this->config->get('config_email'));
        $mail->setFrom($this->config->get('config_email'));
        $mail->setSender($this->request->post['name']);
        $mail->setSubject(html_entity_decode('Тема письма от '.$this->request->post['name'], ENT_QUOTES, 'UTF-8'));
        $mail->setHtml($html);
        $mail->setText(html_entity_decode($text, ENT_QUOTES, 'UTF-8'));
        $mail->send();
        $json['success'] = true;
      }
    }
    
    $this->response->setOutput(json_encode($json));
  }	
