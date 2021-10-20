<?php
/**
 * Created by PhpStorm.
 * User: autoDump
 * Year: 2021-07-20
 */

namespace Repository;

use App\Models\UserProxy;
use App\Repositories\Contracts\UserProxyRepositoryInterface;
use Repository\BaseRepository;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;

class UserProxyRepository extends BaseRepository implements UserProxyRepositoryInterface
{

     public function __construct(Application $app)
     {
         parent::__construct($app);

     }

    /**
       * Instantiate model
       *
       * @param UserProxy $model
       */

    public function model()
    {
        return UserProxy::class;
    }


}
