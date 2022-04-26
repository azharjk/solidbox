import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

import { UserRegister, UserToken } from './user';

@Injectable({
  providedIn: 'root',
})
export class UserService {

  readonly API_URL = 'http://localhost:8000/api';

  constructor(private http: HttpClient) {}

  register(user: UserRegister) {
    return this.http.post<UserToken>(
      `${this.API_URL}/register`,
      user
    );
  }
}
