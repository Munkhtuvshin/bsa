'use strict';

import React, { Component } from 'react'
import { render } from 'react-dom'
import Chart from 'chart.js'
import { Label, Tab, Button, Container, Header, List } from 'semantic-ui-react'

class Logout extends Component {
    constructor(props) {
        super(props);
        sessionStorage.removeItem('accessToken')
    }

    render() {
      return (
          <Container style={{ width: '400px', margin: '100px' }}>
                   
          </Container>
      )
    }
}

export default Logout;