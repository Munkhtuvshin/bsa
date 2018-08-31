import { createClass, createElement, cloneElement } from 'react'
import assign from 'lodash.assign'

function getDisplayName({ displayName, name }) {
  return displayName || name || 'Component'
}

export default function withStyle(style) {
  return (WrappedComponent) => createClass({
    displayName: `WithStyle(${getDisplayName(WrappedComponent)})`,

    render() {
      const el = createElement(WrappedComponent, this.props)

      return cloneElement(el, assign({}, el.props, {
        style: assign({}, el.props.style, style)
      }))
    }
  })
}
