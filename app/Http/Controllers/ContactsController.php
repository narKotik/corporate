<?php

namespace Corp\Http\Controllers;

use Illuminate\Http\Request;
use Corp\Repositories\MenusRepository;
use Corp\Menu;
use Mail;

class ContactsController extends SiteController
{
    public function __construct()
    {
        parent::__construct(new MenusRepository(new Menu()));

        $this->bar = 'left';

        $this->template = config('settings.theme') . '.contacts';
    }

    public function index(Request $request)
    {
        if ($request->isMethod('post')) {

            $messages = [
                'required' => 'Поле :attribute обязательно к заполнению',
                'email'    => 'Поле :attribute должно содержать правильный email адрес',
            ];

            $this->validate($request, [
                'name' => 'required|max:255',
                'email' => 'required|email',
                'text' => 'required'
            ]/*,$messages*/);

            $data = $request->all();

            $result = Mail::send(config('settings.theme').'.email', compact('data'), function ($m) use ($data) {
                $mail_admin = env('MAIL_ADMIN');

                $m->from($data['email'], $data['name']);

                $m->to($mail_admin, 'Mr. Admin')->subject('Question');
            });

            return redirect()->route('contacts')->with('status', 'Email is send');
        }

        $this->title = 'Контакты';

        $content = view(config('settings.theme') . '.contact_content')->render();
        $this->vars['content'] = $content;

        $this->contentLeftBar = view(config('settings.theme') . '.contact_bar')->render();

        return $this->renderOutput();
    }
}
