<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Customer;
use App\Models\Employee;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class CustomerPolicy
{
    use HandlesAuthorization;

    public function viewAny($user)
    {
        return true;
    }

   
    /**
     * Determine whether the user can view the model.
     */
    public function view($user, Customer $customer)
    {
        return $this->checkAuthorization($user, $customer);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Admin $admin): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update( $user, Customer $customer): bool
    {
        return $this->checkAuthorization($user, $customer);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete( $user, Customer $customer): bool
    {
        return $this->checkAuthorization($user, $customer);
    }

    protected function checkAuthorization($user, Customer $customer)
    {
        if ($user instanceof Admin) {
            return true;
        }

        if ($user instanceof Employee) {
            return $customer->employees->contains($user->id);
        }

        return false;
    }
}
