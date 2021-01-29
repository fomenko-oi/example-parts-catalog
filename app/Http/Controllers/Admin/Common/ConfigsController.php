<?php

namespace App\Http\Controllers\Admin\Common;

use App\Entity\Common\Config;
use App\Http\Controllers\Controller;
use App\UseCase\Common\ConfigService;
use Illuminate\Http\Request;

class ConfigsController extends Controller
{
    /**
     * @var ConfigService
     */
    private ConfigService $configService;

    public function __construct(ConfigService $configService)
    {
        $this->configService = $configService;
    }

    public function create()
    {
        return view('admin.common.config.create');
    }

    public function store(Request $request)
    {
        try {
            Config::create([
                'name' => $request->get('name'),
                'key' => $request->get('key'),
                'value' => $request->get('value'),
                'autoload' => !!$request->get('autoload'),
            ]);

            return redirect()->route('admin.configs.index')->with('success', 'Config successful created.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput($request->all());
        }
    }

    public function edit(Config $config)
    {
        return view('admin.common.config.edit', compact('config'));
    }

    public function update(Request $request, Config $config)
    {
        try {
            $config->update([
                'name' => $request->get('name'),
                'key' => $request->get('key'),
                'value' => $request->get('value'),
                'autoload' => !!$request->get('autoload')
            ]);

            return redirect()->route('admin.configs.index')->with('success', 'Config successful updated.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function remove(Config $config)
    {
        try {
            $config->delete();

            return redirect()->route('admin.configs.index')->with('success', 'Config successful removed.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function index()
    {
        $configs = $this->configService->all();

        return view('admin.common.config.index', compact('configs'));
   }
}
