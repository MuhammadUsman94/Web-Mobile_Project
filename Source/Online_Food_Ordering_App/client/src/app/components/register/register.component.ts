import { Component, OnInit } from '@angular/core';
import Swal from 'sweetalert2/dist/sweetalert2.js';
import { Router } from '@angular/router';
import { AuthService } from 'src/app/services/auth.service';
import { HotelService } from '../../services/hotel.service';

@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.scss']
})
export class RegisterComponent implements OnInit {

  public userRegistration;
  public userName = '';
  constructor(private router: Router, private serviceAuth: AuthService, private serviceHotel: HotelService) { }

  errorCustomization = (statusText, statusMessage) => { // error customization is done with input params
    return {
      statusText: statusText, // defining status text for the customization error 
      message: statusMessage // defining status message for the customization error 
    }
  }
  
  registrationForUser = async() => {// async method is being called for the login
    await Swal.fire({  // alert pop-up is used as a login html file using sweet alerts
    // defining and declaring all the parameters required to create a user understandable html
      imageUrl: 'assets/logo1.png',
      imageWidth: 250,
      imageHeight: 150,
      imageAlt: 'LOGO',
      title: '<strong>Register..</strong>',
      html:
      '<input id="email" type="email" class="swal2-input" autocomplete="off" placeholder="email" required>' +
      '<input id="username" type="text" class="swal2-input" autocomplete="off" placeholder="username" required>' +
      '<input id="password" type="password" class="swal2-input" autocomplete="off" placeholder="password" required>' +
      '<b>Already have an account?</b>&nbsp' +
      '<a href="/login">Click here to login</a> ',
      focusConfirm: false,
      confirmButtonText: 'Sign up',
      confirmButtonColor: '#437e4d',
      allowOutsideClick: false,
      allowEscapeKey: false,
      preConfirm: () => { // preconfirm method is used in this method we are going to extracting the user given inputs
          this.userRegistration = {
            email: (document.getElementById('email') as HTMLInputElement).value, // value of the user given email input is extracted using getelementbyid
            username: (document.getElementById('username') as HTMLInputElement).value,// value of the user given usename input is extracted using getelementbyid
            password: (document.getElementById('password') as HTMLInputElement).value// value of the user given password input is extracted using getelementbyid  
          }
      }
    }).then((result) => { // after extracting the date checking is done basically validation is going on 
      if (result.isConfirmed) { // if statement is used and pre defined isConfirmed method
        if(!this.userRegistration.username || !this.userRegistration.password || !this.userRegistration.email) {  // checking whether the input fields are empty or not
          const userFault = this.errorCustomization("Information Missing", "no fields should be empty"); // if empty then sending the data to the customization error method
          this.errorDisplay(userFault);  // setting the customized error message to the errorDisplay method
        }
        else { // checking 
          if(!this.emailValidation(this.userRegistration.email)) { 
            const userFault = this.errorCustomization("Invalid email format!", "Please enter valid email format (eg. example@example.com)");
            this.errorDisplay(userFault);
          }
          else { // if the details are present the login method in the service layer is called
            this.serviceAuth.userRegistration(this.userRegistration).subscribe(
              (res) => {
                this.homePageNavigation();// a sample delayed sweet alert for styling is used
                // setting the data to the browser local storage using key value pair
                localStorage.setItem('food-token', res.token);
                localStorage.setItem('food-username', res.username);
                localStorage.setItem('food-email', res.email);
                localStorage.setItem('food-userId', res.userId);
                this.router.navigateByUrl("/hotels");
              },
              (error) => {
                if(error.error == 'Email already exist!') {
                  const fault = this.errorCustomization("Email already exist!", "Please try with some other email");
                  this.errorDisplay(fault);
                }
              }
            )
          }
        }
      }
    })
  }
  // email Id validation method
  emailValidation = (emailID) => {
    let anno = emailID.indexOf("@");
    let positonOfDot = emailID.lastIndexOf(".");
    if (anno < 1 || ( positonOfDot - anno < 2 )) {
      return false;
    }
    return true;
  }
// delay sweet alert for styling
  homePageNavigation = () => {
    Swal.fire({
      icon: 'success',
      title: 'Your account has been registered successfully',
      html: 'Redirecting to the dashboard...',
      timer: 2100,
      timerProgressBar: true,
      showConfirmButton: false,
      willOpen: () => {
        Swal.showLoading();
      }
    }).then((result) => { })
  }
// sweet alert for error to display
  errorDisplay = (error) => {
    Swal.fire({
      icon: 'error',
      title: error.statusText,
      text: error.message,
      showConfirmButton: true,
      confirmButtonText: "Try Again",
      confirmButtonColor: '#06581a',
      allowOutsideClick: false,
      allowEscapeKey: false,
    }).then((result) => {
      if (result.isConfirmed) {
        this.registrationForUser();
      }
    })
  }

  ngOnInit(): void {
    this.registrationForUser();
  }

}
