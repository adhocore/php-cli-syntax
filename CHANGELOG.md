## [0.3.0](https://github.com/adhocore/php-cli-syntax/releases/tag/0.3.0) (2019-12-30)

### Bug Fixes
- **Clish.cmd**: Usage msg, font path in phar (Jitendra Adhikari) [_cef8caa_](https://github.com/adhocore/php-cli-syntax/commit/cef8caa)

### Internal Refactors
- Invert font check logic (Jitendra Adhikari) [_1b8cda0_](https://github.com/adhocore/php-cli-syntax/commit/1b8cda0)

### Miscellaneous
- Bump cli (Jitendra Adhikari) [_a684003_](https://github.com/adhocore/php-cli-syntax/commit/a684003)
- **Clish**: Check gd extension (Jitendra Adhikari) [_16d7689_](https://github.com/adhocore/php-cli-syntax/commit/16d7689)
- **Phar**: Add box.json (Jitendra Adhikari) [_048eb60_](https://github.com/adhocore/php-cli-syntax/commit/048eb60)


## [0.2.1](https://github.com/adhocore/php-cli-syntax/releases/tag/0.2.1) (2019-12-28)

### Bug Fixes
- **Clish.cmd**: Ensure file is str (Jitendra Adhikari) [_5509140_](https://github.com/adhocore/php-cli-syntax/commit/5509140)


## [0.2.0](https://github.com/adhocore/php-cli-syntax/releases/tag/0.2.0) (2019-12-28)

### Features
- **Bin**: Add clish entrypoint (Jitendra Adhikari) [_b6dfe0f_](https://github.com/adhocore/php-cli-syntax/commit/b6dfe0f)
- **Console**: Add clish command (Jitendra Adhikari) [_1a36015_](https://github.com/adhocore/php-cli-syntax/commit/1a36015)
- **Pretty**: Use domxpath, add reset() and codeToHtml() (Jitendra Adhikari) [_aa65e14_](https://github.com/adhocore/php-cli-syntax/commit/aa65e14)
- Add png Exporter class (Jitendra Adhikari) [_494c4a0_](https://github.com/adhocore/php-cli-syntax/commit/494c4a0)
- Add abstract base Pretty class (Jitendra Adhikari) [_09feb82_](https://github.com/adhocore/php-cli-syntax/commit/09feb82)

### Bug Fixes
- **Clish**: Phar name (Jitendra Adhikari) [_6499722_](https://github.com/adhocore/php-cli-syntax/commit/6499722)
- **Exporter**: Validate output dir (Jitendra Adhikari) [_bd8e3e7_](https://github.com/adhocore/php-cli-syntax/commit/bd8e3e7)
- **Clish**: Phar name (Jitendra Adhikari) [_c82c585_](https://github.com/adhocore/php-cli-syntax/commit/c82c585)

### Internal Refactors
- **Clish.cmd**: Dont trim input, use writer instead of echo (Jitendra Adhikari) [_e30bd02_](https://github.com/adhocore/php-cli-syntax/commit/e30bd02)
- **Exporter**: No static, add setOptions, reset, refactor visit (Jitendra Adhikari) [_6a38fd4_](https://github.com/adhocore/php-cli-syntax/commit/6a38fd4)
- **Highlighter**: Implement reset(), refactor visit() (Jitendra Adhikari) [_e6d6b4e_](https://github.com/adhocore/php-cli-syntax/commit/e6d6b4e)
- Extend Pretty, cleanup redundant (Jitendra Adhikari) [_772c3d7_](https://github.com/adhocore/php-cli-syntax/commit/772c3d7)

### Miscellaneous
- Update test:cov (Jitendra Adhikari) [_285182f_](https://github.com/adhocore/php-cli-syntax/commit/285182f)
- Update example output (Jitendra Adhikari) [_4867ec3_](https://github.com/adhocore/php-cli-syntax/commit/4867ec3)
- **Composer**: Add keywords, use adhocore/cli, register clish (Jitendra Adhikari) [_3652e5f_](https://github.com/adhocore/php-cli-syntax/commit/3652e5f)
- Chmod +x clish (Jitendra Adhikari) [_3982889_](https://github.com/adhocore/php-cli-syntax/commit/3982889)
- Update gitignore (Jitendra Adhikari) [_c0f09e1_](https://github.com/adhocore/php-cli-syntax/commit/c0f09e1)
- Add more fonts (Jitendra Adhikari) [_0184d40_](https://github.com/adhocore/php-cli-syntax/commit/0184d40)
- Add export example image output (Jitendra Adhikari) [_eb2ef0f_](https://github.com/adhocore/php-cli-syntax/commit/eb2ef0f)
- Add export example (Jitendra Adhikari) [_8f88fa9_](https://github.com/adhocore/php-cli-syntax/commit/8f88fa9)
- Require gd ext (Jitendra Adhikari) [_c41b11c_](https://github.com/adhocore/php-cli-syntax/commit/c41b11c)
- Add dejavu font (Jitendra Adhikari) [_0927f75_](https://github.com/adhocore/php-cli-syntax/commit/0927f75)

### Documentations
- Add global installation docs (Jitendra Adhikari) [_ddcbfd4_](https://github.com/adhocore/php-cli-syntax/commit/ddcbfd4)
- About extension (Jitendra Adhikari) [_32aa562_](https://github.com/adhocore/php-cli-syntax/commit/32aa562)
- Add customisation info (Jitendra Adhikari) [_9565097_](https://github.com/adhocore/php-cli-syntax/commit/9565097)
- Add export usage (Jitendra Adhikari) [_d91624f_](https://github.com/adhocore/php-cli-syntax/commit/d91624f)


## [0.1.0](https://github.com/adhocore/php-cli-syntax/releases/tag/0.1.0) (2019-12-21)

### Features
- Add highlighter (Jitendra Adhikari) [_a7a0ca2_](https://github.com/adhocore/php-cli-syntax/commit/a7a0ca2)

### Internal Refactors
- Make code param optional (Jitendra Adhikari) [_d41b677_](https://github.com/adhocore/php-cli-syntax/commit/d41b677)

### Miscellaneous
- Fix example.phps (Jitendra Adhikari) [_ef633bb_](https://github.com/adhocore/php-cli-syntax/commit/ef633bb)
- **Composer**: Fix package name (Jitendra Adhikari) [_7f9912e_](https://github.com/adhocore/php-cli-syntax/commit/7f9912e)
- **Composer**: Add test:cov, require ext-dom (Jitendra Adhikari) [_6087842_](https://github.com/adhocore/php-cli-syntax/commit/6087842)
- Add example script (Jitendra Adhikari) [_c2c8808_](https://github.com/adhocore/php-cli-syntax/commit/c2c8808)
- Add github meta files (Jitendra Adhikari) [_e14ede6_](https://github.com/adhocore/php-cli-syntax/commit/e14ede6)
- **Composer**: Add composer json (Jitendra Adhikari) [_5c38863_](https://github.com/adhocore/php-cli-syntax/commit/5c38863)
- Add license, changelog, contributing (Jitendra Adhikari) [_bc73517_](https://github.com/adhocore/php-cli-syntax/commit/bc73517)
- Init (Jitendra Adhikari) [_722a725_](https://github.com/adhocore/php-cli-syntax/commit/722a725)

### Documentations
- Styleci (Jitendra Adhikari) [_cfb88ef_](https://github.com/adhocore/php-cli-syntax/commit/cfb88ef)
- Update usage, add screenshot (Jitendra Adhikari) [_11526f7_](https://github.com/adhocore/php-cli-syntax/commit/11526f7)
- Add readme (Jitendra Adhikari) [_21b5b8a_](https://github.com/adhocore/php-cli-syntax/commit/21b5b8a)

### Builds
- **Travis**: Add travis yml (Jitendra Adhikari) [_e75bee9_](https://github.com/adhocore/php-cli-syntax/commit/e75bee9)
