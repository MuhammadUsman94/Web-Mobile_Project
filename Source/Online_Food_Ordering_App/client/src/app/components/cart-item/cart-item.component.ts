import { Component, OnInit, Input, Output, EventEmitter } from '@angular/core';

@Component({
  selector: 'app-cart-item',
  templateUrl: './cart-item.component.html',
  styleUrls: ['./cart-item.component.scss']
})
export class CartItemComponent implements OnInit {

 // input and output directives to emit the event
  @Output() eventForQuantityAddition = new EventEmitter(); 
  @Output() eventForItemDeletion = new EventEmitter(); 
  @Output() eventForQuantityDeletion = new EventEmitter();
  @Input() public saveItems;

  
// quantity deletion method to emit
  quantityDelete = (saveItem) => {
    this.eventForQuantityDeletion.emit(saveItem);
  }
// quantity addition method to emit
  quantityAddition = (saveItem) => {
    this.eventForQuantityAddition.emit(saveItem);
  }
// item deletion method to emit
  ItemDeletion = (saveItem) => {
    this.eventForItemDeletion.emit(saveItem);
  }

  ngOnInit(): void {
  }
  constructor() { }
}
