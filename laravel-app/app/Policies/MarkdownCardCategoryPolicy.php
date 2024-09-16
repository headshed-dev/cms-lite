<?php

namespace App\Policies;

use App\Models\User;
use App\Models\MarkdownCardCategory;
use Illuminate\Auth\Access\HandlesAuthorization;

class MarkdownCardCategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_markdown::card::category');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, MarkdownCardCategory $markdownCardCategory): bool
    {
        return $user->can('view_markdown::card::category');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_markdown::card::category');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, MarkdownCardCategory $markdownCardCategory): bool
    {
        return $user->can('update_markdown::card::category');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, MarkdownCardCategory $markdownCardCategory): bool
    {
        return $user->can('delete_markdown::card::category');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_markdown::card::category');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, MarkdownCardCategory $markdownCardCategory): bool
    {
        return $user->can('force_delete_markdown::card::category');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_markdown::card::category');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, MarkdownCardCategory $markdownCardCategory): bool
    {
        return $user->can('restore_markdown::card::category');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_markdown::card::category');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, MarkdownCardCategory $markdownCardCategory): bool
    {
        return $user->can('replicate_markdown::card::category');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_markdown::card::category');
    }
}
