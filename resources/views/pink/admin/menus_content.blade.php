<div id="content-page" class="content group">
    <div class="hentry group">
        <h3 class="title_page">Пользователи</h3>


        <div class="short-table white">
            <table style="width: 100%" cellspacing="0" cellpadding="0">
                <thead>
                <tr>
                    <th>Название</th>
                    <th>Ссылка</th>
                    <th>Удалить</th>
                </tr>
                </thead>
                @if($menu)

                    @include(config('settings.theme').'.admin.custom-menu-items', ['items' => $menu->roots(),'paddingLeft' => ''])

                @endif
            </table>
        </div>
        {!! HTML::link(route('menus.create'),'Добавить  пункт',['class' => 'btn btn-the-salmon-dance-3']) !!}
    </div>
</div>