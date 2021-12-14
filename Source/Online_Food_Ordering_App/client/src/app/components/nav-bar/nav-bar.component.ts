import { Component, OnInit, Input } from '@angular/core';
import { Router } from '@angular/router';
import { AuthService } from 'src/app/services/auth.service';
import Swal from 'sweetalert2/dist/sweetalert2.js';


@Component({
  selector: 'app-nav-bar',
  templateUrl: './nav-bar.component.html',
  styleUrls: ['./nav-bar.component.scss']
})
export class NavBarComponent implements OnInit {

  @Input() public userName;

  constructor(private router: Router, private serviceAuth: AuthService) { }
// method to navigate to the home page
  goToHome = () => {
    this.router.navigateByUrl("/hotels");
  }
// method to logout
  userLoginOff = () => {
    this.loginPageRedirection()
  }
// sweet alert for logout
  loginPageRedirection = () => {
    Swal.fire({
      icon: 'success',
      title: 'Logging out',
      html: 'LoginPage Redirection taking place, Please Wait for a second',
      timer: 2100,
      timerProgressBar: true,
      showConfirmButton: false,
      willOpen: () => {
        Swal.showLoading();
      }
    }).then((result) => {
      this.serviceAuth.userLoginOff();
    })
  }
// sweet alert for about
About = () =>{
  Swal.fire({
    imageUrl: 'assets/image2.JPG',
    imageWidth: 400,
    imageHeight: 200,
    title: 'U-Pep',
    text: 'Online food Delivery Application',
    confirmButtonColor: '#437e4d',
    showClass: {
      popup: 'animate__animated animate__fadeInDown'
    },
    hideClass: {
      popup: 'animate__animated animate__fadeOutUp'
    }
  })
}
// sweet alert for to contact
contact = () =>{
  Swal.fire({
    imageUrl: 'assets/image2.JPG',
    imageWidth: 400,
    imageHeight: 200,
    title: 'U-Pep',
    text: 'U-pep@delivery.com',
    confirmButtonColor: '#437e4d',
    showClass: {
      popup: 'animate__animated animate__fadeInDown'
    },
    hideClass: {
      popup: 'animate__animated animate__fadeOutUp'
    }
  })
}
  ngOnInit(): void {
  }

}
