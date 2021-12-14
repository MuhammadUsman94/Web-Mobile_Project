import { Component, OnInit } from '@angular/core';
import Swal from 'sweetalert2/dist/sweetalert2.js';
import { Router } from '@angular/router';
import { AuthService } from 'src/app/services/auth.service';
import { HotelService } from '../../services/hotel.service';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {

  public userLogin;

  constructor(private router: Router, private serviceAuth: AuthService, private serviceHotel: HotelService) { } // passing the parameters to the constructor 

  errorCustomization = (statusText, statusMessage) => { // error customization is done with input params
    return {
      statusText: statusText, // defining status text for the customization error 
      message: statusMessage // defining status message for the customization error 
    }
  }

  userLoginMethod = async() => {  // async method is being called for the login
    await Swal.fire({  // alert pop-up is used as a login html file using sweet alerts
    // defining and declaring all the parameters required to create a user understandable html
      imageUrl: 'assets/logo1.png',
      imageWidth: 250,
      imageHeight: 150,
      imageAlt: 'LOGO',
      title: '<strong>Login into your account</strong>',
      html:
      '<input class="swal2-input"  placeholder="Enter your Email" required> id="username"" ' +
      '<input class="swal2-input" placeholder="Enter your password" required>  id="securityKey" type="password" ' +
      '<b>New to U-pep?</b>&nbsp' +
      '<a href="/register">Create account</a> ',
      allowEscapeKey: false,
      focusConfirm: false,
      confirmButtonText: 'LogIn',
      confirmButtonColor: '#437e4d',
      allowOutsideClick: false,
      preConfirm: () => { // preconfirm method is used in this method we are going to extracting the user given inputs
          this.userLogin = {
            gmail: (document.getElementById('username') as HTMLInputElement).value, // value of the user given email input is extracted using getelementbyid
            securityKey: (document.getElementById('securityKey') as HTMLInputElement).value // value of the user given password input is extracted using getelementbyid
          }
      }
    }).then((final) => { // after extracting the date checking is done basically validation is going on 
      if (final.isConfirmed) { // if statement is used and pre defined isConfirmed method
        if(!this.userLogin.gmail || !this.userLogin.securityKey) { // checking whether the input fields are empty or not
          const userFault = this.errorCustomization("Information Missing", "no fields should be empty"); // if empty then sending the data to the customization error method
          this.errorDisplay(userFault); // setting the customized error message to the errorDisplay method
        }
        else { // if the details are present the login method in the service layer is called
          this.serviceAuth.userLogin(this.userLogin).subscribe( // connecting to the backend in the service layer is done and data from the back ending is extracted using .subscribe
            (res) => {
              this.homePageNavigation(); // a sample delayed sweet alert for styling is used
              // setting the data to the browser local storage using key value pair
              localStorage.setItem('food-email', res.email);
              localStorage.setItem('food-username', res.username);
              localStorage.setItem('food-userId', res.userId);
              localStorage.setItem('food-token', res.token);
              this.router.navigateByUrl("/hotels"); // navigation is done to the hotels html page after successful login 
            },
            // if any error occur handling is done
            (error) => {
              if(error.statusText == 'Unauthorized') {
                const userFault = this.errorCustomization("Details not present", "Check your details");
                this.errorDisplay(userFault);
              }
              if(error.error == "Email doesn't exist!") {
                const userFault = this.errorCustomization("Check your gmail", "Check your details");
                this.errorDisplay(userFault);
              }
              if(error.error == "Incorrect Password!") {
                const userFault = this.errorCustomization("Check your password", "Check your details");
                this.errorDisplay(userFault);
              }
            }
          )
        }
      }
    })
  }

  // sweet alert delay for styling
  homePageNavigation = () => {
    Swal.fire({
      icon: 'success',
      title: 'Logged in successfully',
      html: 'Redirecting to the dashboard...',
      timer: 3000,
      timerProgressBar: true,
      showConfirmButton: false,
      willOpen: () => {
        Swal.showLoading();
      }
    }).then((result) => { })
  }

  // sweet alert if any error occurs while login
  errorDisplay = (error) => {
    Swal.fire({
      icon: 'error',
      title: error.statusText,
      text: error.message,
      confirmButtonText: "Try Again",
      confirmButtonColor: '#06581a',
      allowOutsideClick: false,
      allowEscapeKey: false,
    }).then((result) => {
      if (result.isConfirmed) {
        this.userLoginMethod();
      }
    })
  }

  ngOnInit(): void {
    this.userLoginMethod();
  }

}
