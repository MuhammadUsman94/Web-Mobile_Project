import { Component, OnInit, Input, Output, EventEmitter } from '@angular/core';

@Component({
  selector: 'app-menu-item',
  templateUrl: './menu-item.component.html',
  styleUrls: ['./menu-item.component.scss']
})
export class MenuItemComponent implements OnInit {

  @Input() public hotel;

  @Output() cartEvent = new EventEmitter();

  constructor() { }

  cartAddition = (card) => {
    this.cartEvent.emit(card);
  }

  ngOnInit(): void {
  }

}
