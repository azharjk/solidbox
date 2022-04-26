export interface UserToken {
  data: {
    token: string;
  };
}

export interface UserRegister {
  name: string;
  username: string;
  password: string;
}
