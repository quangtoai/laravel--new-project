<?php
/**
 * Created by PhpStorm.
 * User: cuongnt
 * Year: 2021-06-04
 */

namespace Repository;

use App\Models\Setting;
use App\Repositories\Contracts\SettingRepositoryInterface;
use Repository\BaseRepository;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;

class SettingRepository extends BaseRepository implements SettingRepositoryInterface
{

    public function __construct(Application $app)
    {
        parent::__construct($app);

    }

    /**
     * Instantiate model
     *
     * @param Setting $model
     */

    public function model()
    {
        return Setting::class;
    }
}



