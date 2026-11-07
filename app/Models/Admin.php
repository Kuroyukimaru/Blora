<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    /*
    |--------------------------------------------------------------------------
    | TABLE CONFIGURATION
    |--------------------------------------------------------------------------
    |
    | Seluruh akun sistem disimpan di tabel users.
    |
    | Role yang digunakan:
    |
    | admin
    | kasir_menu
    | kasir_wahana
    | kasir_oleholeh
    |
    */

    protected $table = 'users';


    /*
    |--------------------------------------------------------------------------
    | PRIMARY KEY
    |--------------------------------------------------------------------------
    */

    protected $primaryKey = 'id_user';

    public $incrementing = true;

    protected $keyType = 'int';


    /*
    |--------------------------------------------------------------------------
    | TIMESTAMPS
    |--------------------------------------------------------------------------
    */

    public $timestamps = true;


    /*
    |--------------------------------------------------------------------------
    | MASS ASSIGNMENT
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'nama',
        'email',
        'password',
        'role',
    ];


    /*
    |--------------------------------------------------------------------------
    | HIDDEN
    |--------------------------------------------------------------------------
    */

    protected $hidden = [
        'password',
        'remember_token',
    ];


    /*
    |--------------------------------------------------------------------------
    | CASTS
    |--------------------------------------------------------------------------
    */

    protected function casts(): array
    {
        return [
            'id_user' => 'integer',
            'password' => 'hashed',
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | ROLE CONSTANTS
    |--------------------------------------------------------------------------
    */

    public const ROLE_ADMIN = 'admin';

    public const ROLE_KASIR_MENU = 'kasir_menu';

    public const ROLE_KASIR_WAHANA = 'kasir_wahana';

    public const ROLE_KASIR_OLEHOLEH = 'kasir_oleholeh';


    /*
    |--------------------------------------------------------------------------
    | ALL ROLES
    |--------------------------------------------------------------------------
    */

    public static function availableRoles(): array
    {
        return [
            self::ROLE_ADMIN,
            self::ROLE_KASIR_MENU,
            self::ROLE_KASIR_WAHANA,
            self::ROLE_KASIR_OLEHOLEH,
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | ADMIN
    |--------------------------------------------------------------------------
    |
    | Admin memiliki hak untuk mengelola:
    |
    | - Menu
    | - Wahana
    | - Oleh-oleh
    | - Paket Bundling
    | - Event
    |
    */

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }


    /*
    |--------------------------------------------------------------------------
    | KASIR
    |--------------------------------------------------------------------------
    */

    public function isKasir(): bool
    {
        return in_array(
            $this->role,
            [
                self::ROLE_KASIR_MENU,
                self::ROLE_KASIR_WAHANA,
                self::ROLE_KASIR_OLEHOLEH,
            ],
            true
        );
    }


    /*
    |--------------------------------------------------------------------------
    | KASIR MENU
    |--------------------------------------------------------------------------
    |
    | Akses:
    |
    | - Home
    | - Pesanan Menu
    | - Pesanan Bundling
    |
    */

    public function isKasirMenu(): bool
    {
        return $this->role === self::ROLE_KASIR_MENU;
    }


    /*
    |--------------------------------------------------------------------------
    | KASIR WAHANA
    |--------------------------------------------------------------------------
    |
    | Akses:
    |
    | - Home
    | - Pesanan Wahana
    | - Pesanan Bundling
    |
    */

    public function isKasirWahana(): bool
    {
        return $this->role === self::ROLE_KASIR_WAHANA;
    }


    /*
    |--------------------------------------------------------------------------
    | KASIR OLEH-OLEH
    |--------------------------------------------------------------------------
    |
    | Akses:
    |
    | - Home
    | - Pesanan Oleh-oleh
    | - Pesanan Bundling
    |
    */

    public function isKasirOlehOleh(): bool
    {
        return $this->role === self::ROLE_KASIR_OLEHOLEH;
    }


    /*
    |--------------------------------------------------------------------------
    | HAS ROLE
    |--------------------------------------------------------------------------
    */

    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }


    /*
    |--------------------------------------------------------------------------
    | HAS ANY ROLE
    |--------------------------------------------------------------------------
    */

    public function hasAnyRole(array $roles): bool
    {
        return in_array(
            $this->role,
            $roles,
            true
        );
    }


    /*
    |--------------------------------------------------------------------------
    | VALID ROLE
    |--------------------------------------------------------------------------
    */

    public function hasValidRole(): bool
    {
        return in_array(
            $this->role,
            self::availableRoles(),
            true
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ROLE LABEL
    |--------------------------------------------------------------------------
    */

    public function getRoleLabelAttribute(): string
    {
        return match ($this->role) {

            self::ROLE_ADMIN =>
                'Administrator',

            self::ROLE_KASIR_MENU =>
                'Kasir Menu',

            self::ROLE_KASIR_WAHANA =>
                'Kasir Wahana',

            self::ROLE_KASIR_OLEHOLEH =>
                'Kasir Oleh-Oleh',

            default =>
                'Role Tidak Dikenali',
        };
    }


    /*
    |--------------------------------------------------------------------------
    | ROLE KEY
    |--------------------------------------------------------------------------
    */

    public function getRoleKeyAttribute(): string
    {
        return (string) $this->role;
    }


    /*
    |--------------------------------------------------------------------------
    | DASHBOARD ROUTE
    |--------------------------------------------------------------------------
    */

    public function getDashboardRouteAttribute(): ?string
    {
        return match ($this->role) {

            self::ROLE_ADMIN =>
                'admin.dashboard',

            self::ROLE_KASIR_MENU =>
                'kasir.menu.dashboard',

            self::ROLE_KASIR_WAHANA =>
                'kasir.wahana.dashboard',

            self::ROLE_KASIR_OLEHOLEH =>
                'kasir.oleholeh.dashboard',

            default =>
                null,
        };
    }


    /*
    |--------------------------------------------------------------------------
    | DASHBOARD PATH
    |--------------------------------------------------------------------------
    */

    public function getDashboardPathAttribute(): ?string
    {
        return match ($this->role) {

            self::ROLE_ADMIN =>
                '/admin/dashboard',

            self::ROLE_KASIR_MENU =>
                '/kasir-menu/home',

            self::ROLE_KASIR_WAHANA =>
                '/kasir-wahana/home',

            self::ROLE_KASIR_OLEHOLEH =>
                '/kasir-oleholeh/home',

            default =>
                null,
        };
    }


    /*
    |--------------------------------------------------------------------------
    | SIDEBAR PESANAN LABEL
    |--------------------------------------------------------------------------
    */

    public function getOrderLabelAttribute(): ?string
    {
        return match ($this->role) {

            self::ROLE_KASIR_MENU =>
                'Pesanan Menu',

            self::ROLE_KASIR_WAHANA =>
                'Pesanan Wahana',

            self::ROLE_KASIR_OLEHOLEH =>
                'Pesanan Oleh-Oleh',

            default =>
                null,
        };
    }


    /*
    |--------------------------------------------------------------------------
    | SIDEBAR PESANAN ICON
    |--------------------------------------------------------------------------
    */

    public function getOrderIconAttribute(): ?string
    {
        return match ($this->role) {

            self::ROLE_KASIR_MENU =>
                'fa-utensils',

            self::ROLE_KASIR_WAHANA =>
                'fa-ticket',

            self::ROLE_KASIR_OLEHOLEH =>
                'fa-bag-shopping',

            default =>
                null,
        };
    }


    /*
    |--------------------------------------------------------------------------
    | SIDEBAR PESANAN ROUTE
    |--------------------------------------------------------------------------
    */

    public function getOrderRouteAttribute(): ?string
    {
        return match ($this->role) {

            self::ROLE_KASIR_MENU =>
                'kasir.menu.pesanan',

            self::ROLE_KASIR_WAHANA =>
                'kasir.wahana.pesanan',

            self::ROLE_KASIR_OLEHOLEH =>
                'kasir.oleholeh.pesanan',

            default =>
                null,
        };
    }


    /*
    |--------------------------------------------------------------------------
    | BUNDLING ROUTE
    |--------------------------------------------------------------------------
    |
    | Semua kasir mempunyai menu:
    |
    | Pesanan Bundling
    |
    */

    public function getBundlingRouteAttribute(): ?string
    {
        return match ($this->role) {

            self::ROLE_KASIR_MENU =>
                'kasir.menu.bundling',

            self::ROLE_KASIR_WAHANA =>
                'kasir.wahana.bundling',

            self::ROLE_KASIR_OLEHOLEH =>
                'kasir.oleholeh.bundling',

            default =>
                null,
        };
    }


    /*
    |--------------------------------------------------------------------------
    | BUNDLING LABEL
    |--------------------------------------------------------------------------
    */

    public function getBundlingLabelAttribute(): ?string
    {
        if (!$this->isKasir()) {
            return null;
        }

        return 'Pesanan Bundling';
    }


    /*
    |--------------------------------------------------------------------------
    | ADMIN CRUD ACCESS
    |--------------------------------------------------------------------------
    |
    | Digunakan untuk mengecek apakah user merupakan administrator
    | yang boleh masuk ke modul CRUD.
    |
    */

    public function canManageMasterData(): bool
    {
        return $this->isAdmin();
    }


    /*
    |--------------------------------------------------------------------------
    | ADMIN MENU ACCESS
    |--------------------------------------------------------------------------
    */

    public function canManageMenu(): bool
    {
        return $this->isAdmin();
    }


    /*
    |--------------------------------------------------------------------------
    | ADMIN WAHANA ACCESS
    |--------------------------------------------------------------------------
    */

    public function canManageWahana(): bool
    {
        return $this->isAdmin();
    }


    /*
    |--------------------------------------------------------------------------
    | ADMIN OLEH-OLEH ACCESS
    |--------------------------------------------------------------------------
    */

    public function canManageOlehOleh(): bool
    {
        return $this->isAdmin();
    }


    /*
    |--------------------------------------------------------------------------
    | ADMIN BUNDLING ACCESS
    |--------------------------------------------------------------------------
    */

    public function canManageBundling(): bool
    {
        return $this->isAdmin();
    }


    /*
    |--------------------------------------------------------------------------
    | ADMIN EVENT ACCESS
    |--------------------------------------------------------------------------
    */

    public function canManageEvent(): bool
    {
        return $this->isAdmin();
    }


    /*
    |--------------------------------------------------------------------------
    | KASIR MENU ORDER ACCESS
    |--------------------------------------------------------------------------
    */

    public function canProcessMenuOrder(): bool
    {
        return $this->isKasirMenu();
    }


    /*
    |--------------------------------------------------------------------------
    | KASIR WAHANA ORDER ACCESS
    |--------------------------------------------------------------------------
    */

    public function canProcessWahanaOrder(): bool
    {
        return $this->isKasirWahana();
    }


    /*
    |--------------------------------------------------------------------------
    | KASIR OLEH-OLEH ORDER ACCESS
    |--------------------------------------------------------------------------
    */

    public function canProcessOlehOlehOrder(): bool
    {
        return $this->isKasirOlehOleh();
    }


    /*
    |--------------------------------------------------------------------------
    | BUNDLING ORDER ACCESS
    |--------------------------------------------------------------------------
    |
    | Ketiga jenis kasir boleh melihat/memproses pesanan bundling.
    |
    */

    public function canProcessBundlingOrder(): bool
    {
        return $this->isKasir();
    }


    /*
    |--------------------------------------------------------------------------
    | CAN ACCESS ORDER
    |--------------------------------------------------------------------------
    |
    | Mengecek jenis pesanan yang boleh ditangani oleh kasir.
    |
    */

    public function canProcessOrderType(string $type): bool
    {
        return match ($type) {

            'menu' =>
                $this->isKasirMenu(),

            'wahana' =>
                $this->isKasirWahana(),

            'oleholeh' =>
                $this->isKasirOlehOleh(),

            'bundling' =>
                $this->isKasir(),

            default =>
                false,
        };
    }


    /*
    |--------------------------------------------------------------------------
    | IS ADMINISTRATOR OR KASIR
    |--------------------------------------------------------------------------
    */

    public function isAdministratorOrKasir(): bool
    {
        return $this->hasValidRole();
    }
}