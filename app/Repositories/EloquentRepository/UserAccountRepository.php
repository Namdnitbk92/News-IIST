<?php 

namespace App\Repositories\EloquentRepository;

use App\Repositories\BaseRepository;
use App\UsersAccount;

class UserAccountRepository extends BaseRepository
{
	public function __construct(UsersAccount $userAccount)
	{
		parent::__construct($userAccount);
	}
}
