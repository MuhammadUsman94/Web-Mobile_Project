import { Injectable } from '@angular/core';
import { HttpClient, HttpErrorResponse } from '@angular/common/http';
import { Observable, Subject, throwError } from 'rxjs';
import { IRestaurants } from '../models/Restaurants';
import { catchError } from 'rxjs/operators';
import { ICartItem } from '../models/cart-item';
import { environment } from 'src/environments/environment';
import { IOrder } from '../models/order';

@Injectable({
  providedIn: 'root'
})
export class RestaurantsService {

  private restaurantURL: string = (environment.baseURL) ? `${environment.baseURL}api/Restaurantss` : 'api/Restaurantss';
  private URLforOrders: string = (environment.baseURL) ? `${environment.baseURL}api/order` : 'api/order';

  public errorCustomization = {
    status: 400,
    message: 'not found'
  }
  

  constructor(private httpClient: HttpClient) {

    this.savedItemsChange.subscribe((value: ICartItem[]) => {
      this.savedItems.push(value);
    });
    this.nameChange.subscribe((name) => {
      this.userName = name;
    });
    this.gmailChange.subscribe((gmail) => {
      this.gmail = gmail;
    });
    this.userIdChange.subscribe((userId) => {
      this.userId = userId;
    });
    this.orderHistoryChange.subscribe((orderHist) => {
      this.orderHistory = orderHist;
    })
  }
//to call the restaurant retrive method
  public retriveRestaurants = (): Observable<IRestaurants[]> => {
    // returning the string data from the server side
    return this.httpClient.get<IRestaurants[]>(this.restaurantURL).pipe(
      catchError((fault: HttpErrorResponse) => { //catcherror is used to check the response status
        return throwError(fault || this.errorCustomization);
      })
    );
  }

  public RestaurantsRetrive = (RestaurantsId: string): Observable<IRestaurants> => {//restaurant retrive method in the service layer which is used to authentication purpose
    return this.httpClient.get<IRestaurants>(`${this.restaurantURL}/${RestaurantsId}`).pipe(
      catchError((fault: HttpErrorResponse) => { //catcherror is used to check the response status
        return throwError(fault || this.errorCustomization);
      })
    );
  }

  public orderSaved = (orders, userId): Observable<any> => { //ordersave method in the service layer which is used to authentication purpose
    this.clearAllsavedItems();
    return this.httpClient.post<any>(`${this.URLforOrders}/${userId}`, orders).pipe(
      catchError((fault: HttpErrorResponse) => { //catcherror is used to check the response status
        return throwError(fault || this.errorCustomization);
      })
    );
  }

  public retriveorder = (userId): Observable<IOrder[]> => { //retriveOrder method in the service layer which is used to authentication purpose
    return this.httpClient.get<IOrder[]>(`${this.URLforOrders}/${userId}`).pipe(
      catchError((fault: HttpErrorResponse) => { //catcherror is used to check the response status
        return throwError(fault || this.errorCustomization);
      })
    );
  }

  //setters
  public setUserName = (name) => {
    this.nameChange.next(name);
  }

  public setgmail = (gmail) => {
    this.gmailChange.next(gmail);
  }

  public cartItemDeletion = (item) => {
    this.savedItems = this.savedItems.filter((menu) => card.id != item.id);
  }

  public clearAllsavedItems = () => {
    this.savedItems = [];
  }

}
