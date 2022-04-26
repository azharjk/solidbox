import { TestBed } from '@angular/core/testing';
import {
  HttpClientTestingModule,
  HttpTestingController,
} from '@angular/common/http/testing';

import { UserService } from './user.service';

describe('UserService', () => {
  let service: UserService;
  let httpMock: HttpTestingController;

  beforeEach(() => {
    TestBed.configureTestingModule({
      imports: [HttpClientTestingModule],
    });

    service = TestBed.inject(UserService);
    httpMock = TestBed.inject(HttpTestingController);
  });

  afterEach(() => {
    httpMock.verify();
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });

  it('#register should return token', () => {
    const dummyToken = {
      data: {
        token: 'token',
      },
    };

    service
      .register({
        name: 'Muhammad Azhari',
        username: 'azharazhar1010',
        password: 'helloworld69',
      })
      .subscribe((data) => {
        expect(data).toEqual(dummyToken);
      });

    const req = httpMock.expectOne(`${service.API_URL}/register`);
    expect(req.request.method).toBe('POST');
    req.flush(dummyToken);
  });
});
