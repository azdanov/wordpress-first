module.exports = {
  root: true,
  extends: ["airbnb-base", "plugin:prettier/recommended"],
  globals: {
    wp: true
  },
  env: {
    node: true,
    es6: true,
    amd: true,
    browser: true,
    jquery: true
  },
  parserOptions: {
    ecmaVersion: 2017,
    sourceType: "module"
  },
  plugins: ["import"],
  settings: {
    "import/core-modules": [],
    "import/ignore": ["node_modules", "\\.(coffee|scss|css|less|hbs|svg|json)$"]
  },
  rules: {
    "no-console": "off",
    "import/prefer-default-export": "off",
    "import/no-extraneous-dependencies": [
      "error",
      {
        devDependencies: true,
        optionalDependencies: false,
        peerDependencies: false
      }
    ],
    "global-require": "off"
  }
};
