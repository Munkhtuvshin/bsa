# react-with-style

Enhance a React component with styles.

## Installation

```sh
npm install --save react-with-style
```

## Usage

```js
import { withStyle } from 'react-with-style'

import MyComponent from './MyComponent'

export default withStyle({
  textAlign: 'center'
})(MyComponent)
```

## API

### `withStyle([style])`

Passes additional styles to the wrapped component. The provided styles take precedence over styles from the owner.

#### Parameters

* [`style`] \(*Object*): Styles to pass to the wrapped component.

## License

MIT
