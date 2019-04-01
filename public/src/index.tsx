import * as React from "react";
import * as ReactDOM from "react-dom";

import { Hello } from "./components/Hello";

const element = <h1>Hello World</h1>;

ReactDOM.render(
	<Hello compiler="TypeScript" framework="React" />,
	document.getElementById( "example" )
);