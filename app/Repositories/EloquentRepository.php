<?php

namespace App\Repositories;

use App\Contracts\Repositories\RepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class EloquentRepository implements RepositoryInterface
{
    protected Model $model;

    public function __construct()
    {
        $this->model = $this->makeModel();
    }

    abstract protected function model(): string;

    abstract protected function withRelations(): array;

    protected function makeModel(): Model
    {
        $modelClass = $this->model();

        return app($modelClass);
    }

    public function query(): Builder
    {
        return $this->model->newQuery();
    }

    public function all(): Collection
    {
        return $this->query()->with($this->withRelations())->get();
    }

    public function paginate(int $perPage = 10): LengthAwarePaginator
    {
        return $this->query()->with($this->withRelations())->paginate($perPage);
    }

    public function find(int $id): ?Model
    {
        return $this->query()->with($this->withRelations())->find($id);
    }

    public function findOrFail(int $id): Model
    {
        return $this->query()->with($this->withRelations())->findOrFail($id);
    }

    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }

    public function update(int $id, array $attributes): Model
    {
        $record = $this->findOrFail($id);
        $record->update($attributes);

        return $record->fresh();
    }

    public function delete(int $id): bool
    {
        $record = $this->findOrFail($id);

        return (bool) $record->delete();
    }

    public function count(): int
    {
        return $this->query()->count();
    }

    public function countWhere(string $column, $value): int
    {
        return $this->query()->where($column, $value)->count();
    }

    public function sum(string $column): float
    {
        return (float) $this->query()->sum($column);
    }

    public function sumWhere(string $column, $value, string $sumColumn): float
    {
        return (float) $this->query()->where($column, $value)->sum($sumColumn);
    }

    public function sumWhereIn(string $column, array $values, string $sumColumn): float
    {
        return (float) $this->query()->whereIn($column, $values)->sum($sumColumn);
    }

    public function pluck(string $value, string $key): Collection
    {
        return $this->query()->pluck($value, $key);
    }
}
