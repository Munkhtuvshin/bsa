import React, { PropTypes } from 'react';
import { Route, Redirect } from 'react-router-dom';

const PrivateRoute = ({ component, exact = false, path, isAuthenticated }) => (
    <Route
      exact={exact}
      path={path}
      render={props => (
        isAuthenticated ? (
          React.createElement(component, props)
        ) : (
          <Redirect to={{
            pathname: '/admin',
            //state: { from: props.location }
          }}/>
        )
      )}
    />
);

export default PrivateRoute;