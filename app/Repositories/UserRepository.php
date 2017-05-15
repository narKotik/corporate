<?php


namespace Corp\Repositories;


use Corp\User;
use Gate;

class UserRepository
    extends Repository
{
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function addUser($request)
    {
        if (Gate::denies('create', $this->model)) {
            abort(403);
        }

        $data = $request->all();

        $user = $this->model->create([
            'name' => $data['name'],
            'login' => $data['login'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        if ($user) {
            $user->roles()->attach($data['role_id']); // привязка роли пользователю
        }

        return ['status' => 'Пользователь добавлен'];
    }

    public function updateUser($request, $user)
    {
        if (Gate::denies('edit', $this->model)) {
            abort(403);
        }

        $data = $request->except('_method', '_token');

        if (isset($data['password']) && $data['password'] == $data['password_confirmation']) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
            unset($data['password_confirmation']);
        }

        $user->fill($data)->update();
        $user->roles()->sync([$data['role_id']]);

        return ['status' => 'Пользователь изменен'];
    }

    public function deleteUser($user)
    {
        if (Gate::denies('delete', $this->model)) {
            abort(403);
        }

        $user->roles()->detach();

        if ($user->delete()) {
            return ['status' => 'Пользователь удален'];
        }
    }
}