import { ComponentFixture, TestBed } from '@angular/core/testing';
import { HttpClientModule } from '@angular/common/http';
import { RouterTestingModule } from '@angular/router/testing';
import { Router } from '@angular/router';
import { of } from 'rxjs';

import { RegisterComponent } from './register.component';
import { UserService } from '../user/user.service';

describe('RegisterComponent', () => {
  let component: RegisterComponent;
  let fixture: ComponentFixture<RegisterComponent>;
  let userService: UserService;
  let router: Router;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [HttpClientModule, RouterTestingModule],
      declarations: [RegisterComponent],
    }).compileComponents();

    userService = TestBed.inject(UserService);
    router = TestBed.inject(Router);

    const registerSpy = spyOn(userService, 'register');
    registerSpy.and.returnValue(
      of({
        data: {
          token: 'token123',
        },
      })
    );
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(RegisterComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });

  it('should call UserService#register with given parameter', () => {
    component.registerForm.controls['name'].setValue('Muhammad Azhari');
    component.registerForm.controls['username'].setValue('azharazhar1010');
    component.registerForm.controls['password'].setValue('helloguys1010');

    component.onSubmit();

    expect(userService.register).toHaveBeenCalledWith({
      name: 'Muhammad Azhari',
      username: 'azharazhar1010',
      password: 'helloguys1010',
    });
  });

  it('should store token to localStorage on submit', () => {
    component.onSubmit();

    expect(localStorage.getItem('token')).toBe('token123');
  });

  it('should navigate to [/] on submit', () => {
    const navigateByUrlSpy = spyOn(router, 'navigateByUrl');

    component.onSubmit();

    expect(navigateByUrlSpy).toHaveBeenCalledWith('/');
  });
});
