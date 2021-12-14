import { Injectable } from '@angular/core';
import { HttpClient, HttpErrorResponse } from '@angular/common/http';
import { Observable, Subject, throwError } from 'rxjs';
import { catchError } from 'rxjs/operators';
import { IRegisterUser } from '../models/register-user';
import { ILoginUser } from '../models/login-user';
import { Router } from '@angular/router';
import { environment } from 'src/environments/environment';

@Injectable({
  providedIn: 'root'
})
export class AuthService {
  private loginByUser: boolean = false;
  private urlForRegister: string = (environment.baseURL) ? `${environment.baseURL}api/register` : 'api/register';
  private urlForLogin: string = (environment.baseURL) ? `${environment.baseURL}api/login` : 'api/login';
 

  positionChange: Subject<boolean> = new Subject<boolean>();
// customization error declaration
  public errorCustomization = {
    position: 404,
    information: 'not found'
  }

  // method call for auth for registration
  public userRegistration = (user: IRegisterUser): Observable<any> => { //userRegistration method in the service layer which is used to authentication purpose
    return this.httpClient.post<any>(this.urlForRegister, user).pipe(
      catchError((responseForError: HttpErrorResponse) => {
        return throwError(responseForError || this.errorCustomization);
      })
    );
  }
 // method call for auth for login
  public userLogin = (userDetails: ILoginUser): Observable<any> => { //userLogin method in the service layer which is used to authentication purpose
    return this.httpClient.post<any>(this.urlForLogin, userDetails).pipe(
      catchError((responseForError: HttpErrorResponse) => { //catcherror is used to check the response status
        return throwError(responseForError || this.errorCustomization);
      })
    );
  }
  constructor(private httpClient: HttpClient, private router: Router) {
    this.positionChange.subscribe((value) => {
      this.loginByUser = value;
    })
  }
 // method is used to remove the web browser localStorage Data 
  public userLoginOff = () => {
    localStorage.removeItem('food-userId');
    localStorage.removeItem('food-token');
    localStorage.removeItem('food-email');
    localStorage.removeItem('food-username');
    this.router.navigateByUrl('/login');
  }

}
