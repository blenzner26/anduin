<?php namespace ProcessWire;

## Ordinal functions ##
function ordinal($number) {
    $ends = array('th','st','nd','rd','th','th','th','th','th','th');
    if ((($number % 100) >= 11) && (($number%100) <= 13)):
        return $number. 'th';
    else:
        return $number. $ends[$number % 10];
    endif;
}

## Can user view images?
function UserCanViewImages() {
	if (wire('user')->isLoggedin()):
		$allowableClientArray = file(wire('config')->paths->assets . '/addresses/clients.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
		if (in_array(wire('session')->getIP(), $allowableClientArray)):
##			Attempt to show image if the user’s IP address checks out AND they’re logged.
##			The image server will also analyze the request.
			return true;
		endif;
	endif;
	return false;
}


## Diamond / Star

function Star($theme) {
	if ($theme = "none"):
		return " ⟡ ";
	else:
		return "<span class='{$theme} smallerer'>  ⟡  </span>";
	endif;
}


## Persistant-variable functions
## Belt-and-suspenders routine with cookies failsafing to session variables
## and session to user variables.
## Values will *probably* be saved for logged-in folks, but otherwise no
## effort is made to store variables between sessions

function GetPV($pvName) {
##	Get persistent variable from a cookie if we can.
##	If not, from stored $session variable.
##	If not, from $user variable if we’re logged in.
##	Else, "".
	$val = ($_COOKIE[$pvName] ?? (wire('session')->$pvName ?? ""));
	if (!$val && wire('user')->isLoggedin()):
		$val = (wire('user')->$pvName ?? "");
	endif;
	return $val;
}

function RemovePV($pvName) {	## unset/remove/delete persistent variable
	if (isset($_COOKIE[$pvName])):
		unset($_COOKIE[$pvName]);
		setcookie($pvName, '', 1, "/");
	endif;
	if (isset(wire('session')->$pvName)):
		unset(wire('session')->$pvName);
	endif;
	if (wire('user')->isLoggedin() && isset(wire('user')->$pvName)):
		unset(wire('user')->$pvName);
	endif;
}

function SetPV($pvName, $pvValue) {		## set persistent variable
	if (($_COOKIE[$pvName] ?? "") == $pvValue):
		return;
	endif;
	setcookie($pvName, $pvValue, 0, "/");
	$_COOKIE[$pvName] = $pvValue;
	wire('session')->$pvName = $pvValue;
	if (wire('user')->isLoggedin()):
		wire('user')->$pvName = $pvValue;
	endif;
}

function TogglePV($pvName) {			## toggle persistent variable (boolean)
	if (($_COOKIE[$pvName] ?? (wire('session')->$pvName ?? ((wire('user')->isLoggedin() && wire('user')->$pvName) ?? "")))):
		SetPV($pvName, 0);
	else:
		SetPV($pvName, 1);
		return;
	endif;
}
