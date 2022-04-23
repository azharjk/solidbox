import { ComponentFixture, TestBed } from '@angular/core/testing';

import { CardHeadComponent } from './card-head.component';

describe('CardHeadComponent', () => {
  let component: CardHeadComponent;
  let fixture: ComponentFixture<CardHeadComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ CardHeadComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(CardHeadComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
