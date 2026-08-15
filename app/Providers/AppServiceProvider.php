<?php

namespace App\Providers;

use App\Contracts\Repositories\MobilRepositoryInterface;
use App\Contracts\Repositories\PengembalianRepositoryInterface;
use App\Contracts\Repositories\PenggunaRepositoryInterface;
use App\Contracts\Repositories\PesanRepositoryInterface;
use App\Contracts\Repositories\TransaksiRepositoryInterface;
use App\Repositories\MobilRepository;
use App\Repositories\PengembalianRepository;
use App\Repositories\PenggunaRepository;
use App\Repositories\PesanRepository;
use App\Repositories\TransaksiRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(MobilRepositoryInterface::class, MobilRepository::class);
        $this->app->bind(PenggunaRepositoryInterface::class, PenggunaRepository::class);
        $this->app->bind(TransaksiRepositoryInterface::class, TransaksiRepository::class);
        $this->app->bind(PengembalianRepositoryInterface::class, PengembalianRepository::class);
        $this->app->bind(PesanRepositoryInterface::class, PesanRepository::class);
    }

    public function boot(): void
    {
        //
    }
}
