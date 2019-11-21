<?php

defined('BASEPATH') or exit('No direct script access allowed');

include_once(__DIR__ . '/App_pdf.php');

class Ticket_pdf extends App_pdf
{
    protected $ticket;

    public function __construct($ticket)
    {
        $contract                = hooks()->apply_filters('contract_html_pdf_data', $ticket);
        $GLOBALS['ticket_pdf'] = $ticket;

        parent::__construct();

        $this->ticket = $ticket;

        $this->SetTitle($this->ticket->subject);

        # Don't remove these lines - important for the PDF layout
        $this->ticket->content = $this->fix_editor_html($this->ticket->content);
    }

    public function prepare()
    {
        $this->set_view_vars('ticket', $this->ticket);

        return $this->build();
    }

    protected function type()
    {
        return 'ticket';
    }

    protected function file_path()
    {
        $customPath = APPPATH . 'views/themes/' . active_clients_theme() . '/views/my_contractpdf.php';
        $actualPath = APPPATH . 'views/themes/' . active_clients_theme() . '/views/ticketpdf.php';

        if (file_exists($customPath)) {
            $actualPath = $customPath;
        }

        return $actualPath;
    }
}
