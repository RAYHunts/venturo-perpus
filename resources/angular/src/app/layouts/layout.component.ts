import { Component, OnInit, AfterViewInit } from '@angular/core';

import { EventService } from '../core/services/event.service';

import {
  LAYOUT_VERTICAL, LAYOUT_HORIZONTAL
} from './layouts.model';

@Component({
  selector: 'app-layout',
  templateUrl: './layout.component.html',
  styleUrls: ['./layout.component.scss']
})
export class LayoutComponent implements OnInit, AfterViewInit {

  // layout related config
  layoutType: string;
  constructor(private eventService: EventService) { }

  ngOnInit() {
    this.layoutType = LAYOUT_HORIZONTAL;
    this.eventService.subscribe('changeLayout', (layout) => {
      this.layoutType = layout;
    });
  }

  ngAfterViewInit(): void {
      
  }
}
