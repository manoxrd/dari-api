<?php

namespace App;

enum UserRole: string
{
  case Admin = 'admin';
  case Agent = 'agent';
  case Customer = 'customer';
}