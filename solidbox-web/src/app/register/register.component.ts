import { Component, OnInit } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { Router } from '@angular/router';

import { UserRegister } from '../user/user';
import { UserService } from '../user/user.service';

@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.scss', '../login/login.component.scss'],
})
export class RegisterComponent implements OnInit {
  registerForm = new FormGroup({
    name: new FormControl('', [Validators.required]),
    username: new FormControl('', [
      Validators.required,
      Validators.minLength(8),
    ]),
    password: new FormControl('', [
      Validators.required,
      Validators.minLength(8),
    ]),
  });

  constructor(private userService: UserService, private router: Router) {}

  ngOnInit(): void {}

  isInputInvalid(control: 'name' | 'username' | 'password') {
    return (
      this.registerForm.controls[control].invalid &&
      this.registerForm.controls[control].touched
    );
  }

  onSubmit() {
    const user = this.registerForm.value as UserRegister;
    this.userService.register(user).subscribe(({ data }) => {
      localStorage.setItem('token', data.token);
      this.router.navigateByUrl('/');
    });
  }
}
