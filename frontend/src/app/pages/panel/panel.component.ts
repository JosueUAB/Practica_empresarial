import { CommonModule } from '@angular/common';
import { Component } from '@angular/core';
import { RouterModule } from '@angular/router';

@Component({
  selector: 'app-panel',
  standalone: true,
  imports: [
            CommonModule,
            RouterModule
  ],
  templateUrl: './panel.component.html',
  styleUrl: './panel.component.scss'
})
export class PanelComponent {

}
