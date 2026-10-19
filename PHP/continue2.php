<?php 
    // This tells PHP to start or resume a session.
    session_start();

    if (isset($_SESSION['forename'])){
        $forename   =   $_SESSION['forename'];
        $surname    =   $_SESSION['surname'];

        destroy_session_and_data();

        echo htmlspecialchars("Welcome back $forename");
        echo "<br>";
        echo htmlspecialchars("Your full name is $forename $surname.");
    }
    else echo "Please <a href='authenticate2.php'>Click here</a> to log in.";

    function destroy_session_and_data(){
        // Empty the session array. This replaces the session array with an empty array.
        // In modern PHP, you can also write: $_SESSION = [];
        $_SESSION   =   array();
        
        // Get the session cookie parameters
        /**PHP sessions commonly use a browser cookie to identify which session belongs to the visitor.
                This function retrieves the current session cookie settings, such as:
                - lifetime: how long the cookie lasts.
                - path: the URL path for which the cookie is available.
                - domain: the domain to which it applies.
                - secure: whether HTTPS is required.
                - httponly: whether JavaScript can access the cookie.
                The result is an associative array, and this code stores it in $params.
                For example, $params['path'] might contain /. */
        $params     =   session_get_cookie_params();
        
        //Expire the session cookie
        /**The same call written across several lines is easier to read. PHP accepts it either way.
        Here is what each argument means:
        Argument	        Purpose
        session_name()	    Gets the name of the session cookie, commonly PHPSESSID.
        ''	                Sets the cookie's value to an empty string.
        time() - 2592000	Sets its expiration time to a point 30 days in the past.
        $params['path']	    Uses the session cookie's configured path.
        Why subtract 2592000?
        There are 2,592,000 seconds in 30 days:
         30 * 24 * 60 * 60 = 2592000  */
        setcookie(
            session_name(), 
            '', 
            time() - 2592000, 
            $params['path']
        );

        // Destroy the session
        /**This destroys the data associated with the current session on the server.
        However, session_destroy() alone does not automatically clear the $_SESSION array or expire the browser's session cookie. That is why the function performs those other steps as well.
        Think of the three operations this way:
        
            $_SESSION = array();
            Clears the session values from the current PHP request.

            setcookie(...)
            Tells the browser to expire its session-identifying cookie.

            session_destroy();
            Destroys the server-side session data.

        Together, these steps provide a more complete session cleanup than any one of them alone. */
        session_destroy();
    }
?>