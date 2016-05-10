<?php namespace Modules\User\Http\Controllers\Admin;

use Modules\Core\Contracts\Authentication;
use Modules\User\Http\Requests\CreateUserRequest;
use Modules\User\Http\Requests\UpdateUserRequest;
use Modules\User\Permissions\PermissionManager;
use Modules\User\Repositories\RoleRepository;
use Modules\User\Repositories\UserRepository;

class ProfileController extends BaseUserModuleController
{
    /**
     * @var UserRepository
     */
    private $user;
    /**
     * @var Authentication
     */
    private $auth;

    /**
     * @param PermissionManager $permissions
     * @param UserRepository    $user
     * @param RoleRepository    $role
     * @param Authentication    $auth
     */
    public function __construct(
        PermissionManager $permissions,
        UserRepository $user,
        RoleRepository $role,
        Authentication $auth
    ) {
        parent::__construct();

        $this->permissions = $permissions;
        $this->user = $user;
        $this->role = $role;
        $this->auth = $auth;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int      $id
     * @return Response
     */
    public function edit()
    {
        if (!$this->auth->check()) {
            flash()->error(trans('user::messages.user not found'));

            return redirect()->route('dashboard.index');
        }

        $user = $this->auth->check();

        return view('user::admin.profile.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int               $id
     * @param  UpdateUserRequest $request
     * @return Response
     */
    public function update(UpdateUserRequest $request)
    {
        $user = $this->auth->check();
		$data = $request->all();
		if (empty($data['password']) || $this->auth->login(['login' => $user->email, 'password' => $request->get('old_password')])) {
			$data['password'] = '';
		}
		$data['activated'] = true;

		$this->user->updateAndSyncRoles($user->id, $data, []);

        flash(trans('user::messages.user updated'));

        return redirect()->route('admin.user.profile.edit');
    }
}
