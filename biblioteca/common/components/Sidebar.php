
class Sidebar
{
    public static function items()
    {
        $u = Yii::$app->user->identity ?? null;

        return [
            'Livros' => [
                ['icon' => 'book-open', 'label' => 'Todos', 'url' => ['/livros/index']],
                ['icon' => 'heart',      'label' => 'Favoritos', 'url' => ['/livros/favoritos']],
            ],
            'Dashboard' => $u && $u->is_admin ? [
                ['icon' => 'chart-bar', 'label' => 'Dashboard', 'url' => ['/dashboard/index']],
                ['icon' => 'users',     'label' => 'Fluxo de Pessoas', 'url' => ['/dashboard/fluxo']],
            ] : [],
            'Compras' => ($u && ($u->is_admin || $u->is_trabalhador)) ? [
                ['icon' => 'cart', 'label' => 'Pedidos de Compras', 'url' => ['/compras/index']],
            ] : [],
            // …
        ];
    }
}
