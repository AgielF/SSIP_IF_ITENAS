<?php

namespace App\Controllers;

class ContactController extends BaseController
{
    public function index()
    {
        return view('contact_view');
    }

    public function send()
    {
        $email = service('email');

        $name    = $this->request->getPost('name');
        $from    = $this->request->getPost('email');
        $subject = $this->request->getPost('subject');
        $message = $this->request->getPost('message');

        // EMAIL TUJUAN (ADMIN)
        $email->setTo('agielnanda2004@gmail.com');

        // FROM HARUS EMAIL DOMAIN SENDIRI
        $email->setFrom(config('Email')->fromEmail, config('Email')->fromName);

        // REPLY KE USER
        $email->setReplyTo($from, $name);

        $email->setSubject('[Contact] ' . $subject);

        $email->setMessage("
            <strong>Nama:</strong> {$name}<br>
            <strong>Email:</strong> {$from}<br><br>
            {$message}
        ");

        if ($email->send()) {
            return redirect()->back()->with('success', 'Pesan berhasil dikirim.');
        }

        return redirect()->back()
            ->with('error', 'Pesan gagal dikirim.')
            ->with('debug', $email->printDebugger(['headers', 'subject']));
    }
}
