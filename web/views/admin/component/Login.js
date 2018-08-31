'use strict';

import React, { Component } from 'react'
import { render } from 'react-dom'
import Chart from 'chart.js'
import { Label, Tab, Button, Container, Header, List } from 'semantic-ui-react'

class Login extends Component {
    state = {
        email: '',
        password: '',
    }

    onLogin = () => {
        let {
            email,
            password
        } = this.state
        this.props.onLoginAction({ email, password })
    }

    onEmailChanged = (e) => {
        this.setState({
            email: e.target.value
        })
    }

    onPasswordChanged = (e) => {
        this.setState({
            password: e.target.value
        })
    }

    render() {
      return (
          <div style={{
              backgroundImage: 'url(/img/ubcity70.jpg)',
              backgroundRepeat: 'no-repeat',
              //backgroundAttachment: 'fixed;
              backgroundPosition: 'center',
              height: '100%',
              display: 'flex',
              justifyContent: 'center',
              alignItems: 'center',
          }}>
            <Container style={{ width: '500px' }}>
                <div class="ui middle aligned center aligned grid">
                  <div class="column">
                    <h2 class="ui image header">
                      <div class="content">
                        <h2 style={{ fontFamily: 'Verdana', color: '#fff', marginBottom: 20, }}>Beeco - Замын унаа апп</h2>
                      </div>
                    </h2>
                    <form action="/admin-login" method="post" class="ui large form">
                      <div class="ui stacked secondary  segment">
                        <div class="field">
                          <div class="ui left icon input">
                            <i class="user icon"></i>
                            <input type="text" value={this.state.email} placeholder="E-mail address" onChange={this.onEmailChanged}/>
                          </div>
                        </div>
                        <div class="field">
                          <div class="ui left icon input">
                            <i class="lock icon"></i>
                            <input type="password" name="password" value={this.state.password} onChange={this.onPasswordChanged} placeholder="Password" />
                          </div>
                        </div>
                        <div class="ui fluid large teal submit button" style={{ backgroundColor: '#e0622e'}} onClick={this.onLogin}>
                          Login
                        </div>
                      </div>

                      <div class="ui error message"></div>

                    </form>
                  </div>
                </div>        
            </Container>
          </div>
      )
    }
}

export default Login;