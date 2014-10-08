<?php

class Setting extends Eloquent {

	protected $primaryKey = 'name';

	protected $fillable = array('name', 'value');
}