import { Component, OnInit, Input, Output, EventEmitter } from '@angular/core';

@Component({
  selector: 'app-search-bar',
  templateUrl: './search-bar.component.html',
  styleUrls: ['./search-bar.component.scss']
})
export class SearchBarComponent implements OnInit {

  public hotelSearch = ''; // hotelsearch variable is declared with null or empty value

  @Output() eventForSearch = new EventEmitter(); // output annotation is used for the event to query Search

  constructor() { }
  // when the user clicks on search the following method is executed
  queryForSearch = (query) => {
    this.eventForSearch.emit(query);
  }

  clearSearch = () => { // to clear the search the following method is executed
    this.hotelSearch = ''; // assigning the variable to null to clear the value to empty
    this.eventForSearch.emit(this.hotelSearch); // emit an event for the searchQuery
  }

  ngOnInit(): void {
  }

}
