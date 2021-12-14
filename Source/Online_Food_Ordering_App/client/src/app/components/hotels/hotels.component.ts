import { Component, OnInit } from '@angular/core';
import { Restaurantservice } from '../../services/hotel.service';
import { Router } from '@angular/router';
import { ISortOption } from '../../models/sort-option';
import Swal from 'sweetalert2/dist/sweetalert2.js';

@Component({
  selector: 'app-Restaurants',
  templateUrl: './Restaurants.component.html',
  styleUrls: ['./Restaurants.component.scss']
})
export class RestaurantsComponent implements OnInit {
  
  public Restaurants = []; // empty hotel array is declared 
  public RestaurantsConstant = []; // empty RestaurantsConstant array is declared 
  public userName = ''; // variable username is declared with as empty string

  valSelect = this.sortOptions[0].value; // for sorting default value is assign

  constructor(private serviceAuth: Restaurantservice, private router: Router) { }

  //search method execution
  queryForSearch = (info) => { 
    this.Restaurants = this.RestaurantsConstant.filter((Restaurant) =>  JSON.stringify(Restaurant).toLowerCase().indexOf(info.toLowerCase()) !== -1);
  }
//Sorting the restaurants
  RestaurantsToSort = (valSelect) => {
    // if condition to validate the rating and sorting according to the rating of the restaurants
    if (valSelect === 'rating'){
      this.Restaurants = this.Restaurants.sort((initial,final) => {
        return final.rating - initial.rating
      });
    }
// if condition to validate the reviews and sorting according to the reviews of the restaurants
    else if (valSelect === 'reviews'){
      this.Restaurants = this.Restaurants.sort((initial,final) => {
        return final.reviews - initial.reviews
      });
    }
 // if condition to validate the Username and sorting according to the username of the restaurants
    else if (valSelect === 'Username'){
       function NameCheck (initial, final)  {
        // case-insensitive comparison
        initial = initial.toLowerCase();
        final = final.toLowerCase();
      
        return (initial < final) ? -1 : (initial > final) ? 1 : 0;
      }
      this.Restaurants = this.Restaurants.sort((a,lastname) => {
        return NameCheck(a.name, lastname.name)
      });
    }
  }

  goToHotel = (Restaurant) => {
    this.router.navigate(['/Restaurants', Restaurant.id])
  }

  faultDisplay = (fault) => {
    Swal.fire({
      icon: 'fault',
      allowOutsideClick: false,
      text: fault.message,
      showConfirmButton: false,
      allowEscapeKey: false,
      title: fault.status
    });
  }

  ngOnInit(): void {
    this.serviceAuth.hotelRetrive().subscribe(
      (data) => {
        this.RestaurantsConstant = this.Restaurants = data;
        this.sortRestaurants(this.valSelect);
        this.userName = this.serviceAuth.userName;
      },
      (fault) => {
        if(fault.status === 500) {
          this.router.navigateByUrl('/login');
        }
        else {
          console.log(fault);
          this.faultDisplay(fault);
        }
      }
    );
  }

}
