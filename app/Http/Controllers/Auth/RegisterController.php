<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SignUp\SignUpRequest;
use App\Model\Auth\Entity\Address\AddressDto;
use App\Model\Auth\Entity\Email;
use App\Model\Auth\Entity\Name;
use App\Model\Auth\Entity\Password;
use App\Model\Auth\Entity\Phone;
use App\Model\Auth\Entity\Role;
use App\Model\Auth\Repository\UserRepository;
use App\Model\Auth\Service\PasswordGenerator;
use App\Model\Catalog\Category\Repository\RegionRepository;
use App\Model\Delivery\Repository\CountriesRepository;
use App\Model\Delivery\Repository\CountryRegionCityRepository;
use App\Model\Delivery\Repository\CountryRegionRepository;
use App\Model\Deposit\Entity\Deposit\Balance;
use App\Model\Deposit\Repository\DepositRepository;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Mail;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = RouteServiceProvider::HOME;
    /**
     * @var UserRepository
     */
    private UserRepository $users;
    /**
     * @var PasswordGenerator
     */
    private PasswordGenerator $password;
    /**
     * @var CountriesRepository
     */
    private CountriesRepository $countries;
    /**
     * @var DepositRepository
     */
    private DepositRepository $deposits;

    public function __construct(UserRepository $users, PasswordGenerator $password, CountriesRepository $countries, DepositRepository $deposits)
    {
        $this->middleware('guest');
        $this->users = $users;
        $this->password = $password;
        $this->countries = $countries;
        $this->deposits = $deposits;
    }

    public function showRegistrationForm()
    {
        return view('app.auth.register', [
            'countries' => $this->countries->all()
        ]);
    }

    public function register(SignUpRequest $request)
    {
        try {
            $user = $this->users->create(
                new Email($login = $request->input('email')),
                new Phone($request->input('phone')),
                new Role(Role::USER),
                new Name($request->input('name')),
                new Password(Hash::make($newPassword = $this->password->generate())),
                new AddressDto(
                    $request->input('country_id'),
                    $request->input('region_id'),
                    $request->input('city_id'),
                    $request->input('address'),
                    $request->input('postcode'),
                    true
                )
            );

            $this->deposits->create($user->id, new Balance(0));

            event(new Registered($user));

            $this->guard()->login($user, true);

            Mail::raw("Your credentials for access: login: {$login} password: {$newPassword}", function ($message) use($user) {
                $message->to($user->email)->subject('You have registered on site');
            });

            return redirect()->route('auth.sign_up.success');
        } catch (\Exception $e) {
            return $request->wantsJson()
                ? new Response('', 201)
                : redirect($this->redirectPath())->with('error', $e->getMessage())->withInput($request->all());
        }
    }
}
