<?php

namespace Tests\Feature;

use App\Mail\PleaseConfirmYourEmail;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RegistrationTest extends TestCase
{
   use DatabaseMigrations;

   /** @test */
   public function a_confirmation_email_is_set_upon_registration (){
       Mail::fake();
       $this->post(route('register'),[
           'name' => 'John',
           'email' => 'john@example.com',
           'password' => 'foobar',
           'password_confirmation' => 'foobar'
       ]);
       Mail::assertQueued(PleaseConfirmYourEmail::class);
   }

   /** @test */
   public function user_can_fully_confirm_their_email_address (){
       Mail::fake();
       $this->post('/register',[
           'name' => 'John',
           'email' => 'john@example.com',
           'password' => 'foobar',
           'password_confirmation' => 'foobar'
       ]);

       $user = User::whereName('John')->first();
       $this->assertFalse($user->confirmed);

       $this->assertNotNull($user->confirmation_token);

       $this->get(route('register.confirm',['token'=>$user->confirmation_token]))
           ->assertRedirect(route('threads'));

       $this->assertTrue($user->fresh()->confirmed);

       $this->assertNull($user->fresh()->confirmation_token);
   }

   /** @test */
   public function confirming_an_invalid_token (){
       $this->get(route('register.confirm', ['token'=>'invalid']))
           ->assertRedirect(route('threads'))
           ->assertSessionHas('flash','Unknown token');
   }




}
