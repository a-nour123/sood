<?php

namespace App\Http\Controllers\admin\configure;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Http\Request;
use Validator;
use App\Http\Traits\LdapTrait;
use Illuminate\Support\Facades\Crypt;

class LdapConfigurationController extends Controller
{
    use LdapTrait;
    private $path='admin.content.configure.extras.';
    /**
     * Display extras page
     *
     * @return String
     */
    public function ConfigurationLDAP(){
        $breadcrumbs = [['link' => route('admin.dashboard'), 'name' => __('locale.Dashboard')],
         ['name' => __('locale.LDAP Authentication')]];

        return view($this->path.'LDAP-Configuration', compact('breadcrumbs'));
    }
    /**
     * Display extras page
     *
     * @return String
     */


    public function ConfigurationLDAPSave(Request $request){

        $validator =$request->validate([
            'host' => 'required',
            'port' => 'required|integer',
            'base_on' => 'required',
            'username' => 'required',
            'version' => 'required|integer',
            // 'password' => 'required|regex:/^[^\s].*/',
            'timeout' => 'required|integer',
            'follow' => 'required',
            'ssl' => 'required',
            'tls' => 'required',
        ]);

        $this->UpdateLDAPAttribute('LDAP_DEFAULT_HOSTS',$request->host);
        $this->UpdateLDAPAttribute('LDAP_DEFAULT_PORT',$request->port);
        $this->UpdateLDAPAttribute('LDAP_DEFAULT_BASE_DN',$request->base_on);
        $this->UpdateLDAPAttribute('LDAP_DEFAULT_USERNAME',$request->username);
        $this->UpdateLDAPAttribute('LDAP_DEFAULT_VSERSION',$request->version);
        // $this->UpdateLDAPAttribute('LDAP_DEFAULT_PASSWORD',$request->password);
        $this->UpdateLDAPAttribute('LDAP_DEFAULT_TIMEOUT',$request->timeout);
        $this->UpdateLDAPAttribute('LDAP_DEFAULT_Follow',$request->follow);
        $this->UpdateLDAPAttribute('LDAP_DEFAULT_SSL',$request->ssl);
        $this->UpdateLDAPAttribute('LDAP_DEFAULT_TLS',$request->tls);
        $this->UpdateLDAPAttribute('LDAP_USER_FLITER',$request->filter);


        if ($request->password) {
            if (preg_match('/^[^\s].*/', $request->password)) {
            $this->UpdateLDAPAttribute('LDAP_DEFAULT_PASSWORD',$request->password);
            }else {
                return redirect()->back()->withErrors(['password' => 'The password is required and should not start with a space.']);
            }
        }

        $this->UpdateLDAPAttribute('LDAP_name',$request->LDAP_name);
        $this->UpdateLDAPAttribute('LDAP_email',$request->LDAP_email);
        $this->UpdateLDAPAttribute('LDAP_username',$request->LDAP_username);
        $this->UpdateLDAPAttribute('LDAP_Dapartment',$request->LDAP_Dapartment);
        $this->UpdateLDAPAttribute('LDAP_Password',$request->LDAP_Password);



        return redirect()->route('admin.configure.extras.LDAP-Configuration');
    }

    public function LDAPTestConnection(){
       $data=$this->LdapTestConnect();
       return response()->json($data,200);
    }
    public function UpdateLDAPAttribute($key,$value){
        $setting=Setting::where('name',$key)->update([
            'value' => $value
         ]);
        return $setting;
    }


}
