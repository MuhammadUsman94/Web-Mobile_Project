import { Component, OnInit, Input, Output, EventEmitter  } from '@angular/core';

@Component({
  selector: 'app-dropdown',
  templateUrl: './dropdown.component.html',
  styleUrls: ['./dropdown.component.scss']
})
export class DropdownComponent implements OnInit {

  @Input() public valSelect;  // input annotation directive is used for the event to sort when the user select any sort option
  @Input() public categoryOptions;  // input annotation directive is used for the event to sort
  

  @Output() categoryEvent = new EventEmitter();  // output annotation directive is used for the event to sort

  constructor() { }

  categoryHotels = (valSelect) => { // when the user clicks on dropdown the following method is executed
    this.categoryEvent.emit(valSelect);  // emit an event for the sort
  }

  ngOnInit(): void {
  }

}
