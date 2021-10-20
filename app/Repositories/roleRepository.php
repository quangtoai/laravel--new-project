<?php
/**
 * Created by PhpStorm.
 * User: autoDump
 * Year: 2021-07-15
 */

namespace Repository;

use App\Models\role;
use App\Repositories\Contracts\roleRepositoryInterface;
use Repository\BaseRepository;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;

class RoleRepository extends BaseRepository implements roleRepositoryInterface
{

     public function __construct(Application $app)
     {
         parent::__construct($app);

     }

    /**
       * Instantiate model
       *
       * @param role $model
       */

    public function model()
    {
        return role::class;
    }


}
