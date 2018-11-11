<script>

// WIP - not officially tested...


  // 1 - init
  // store initial search params to compare at the end so we only reload 1x
  // ensure that init & end ALWAYS have '?' properly set
  var initSearch = document.location.search;
  if (initSearch == null || !initSearch.startsWith('?')) {
    initSearch = '?';
  }
  var endSearch = initSearch;

console.log('initSearch:', initSearch);


  // fn definitions
  function appendEndSearch(kvp) {
    // already has a param
    if (endSearch.length > 1) {
      console.log('append ', kvp);
      console.log('to ', endSearch);
      endSearch += '&' + kvp;
    } else {
      endSearch += kvp;
      console.log('append ', endSearch);
    }
  }

  function updateEndSearch(kvp) {
    endSearch = kvp.join('&');
    // prepend with ?
    endSearch = '?' + endSearch.substr(endSearch.startsWith('&') ? 1 : 0);
  }


  /*
  possible scenarios
  1a - params had key and same value - no change
  1b - params had key and Diff value - change
  2 - params did not have key - change
  */
  function insertParam(key, value) {
    console.log('v ', value);
    var paramsHadKey = false;
    var paramsHadSameValue = false;

    key = encodeURI(key);
    value = encodeURI(value);
    var kvp = endSearch.substr(1).split('&');

    var i=kvp.length; var x; while(i--) {
      x = kvp[i].split('=');

      if (x[0]==key) {
        console.log('initSearch already had ' + key);
        paramsHadKey = true;
        if (x[1] == value) {
          // case 1a - no change
          paramsHadSameValue = true;
        } else {
          // case 1b - update
          x[1] = value;
          kvp[i] = x.join('=');
          updateEndSearch(kvp);
        }
        break;
      }
    }

    // case 2
    if(i<0) {
      console.log('initSearch didnt have ' + key);
      appendEndSearch([key,value].join('='));
    }

    if (paramsHadKey && paramsHadSameValue) {
      // no change
      console.log('no change');
    } else {
      console.log('change ', endSearch);
    }
  }


  // handle param values
  insertParam('form_origin', "%%formOrigin%%");
  insertParam('p_lost', "%%pLost%%");

  if (endSearch) {
    // if changes were made, reload page 1x
    if (initSearch != endSearch) {
      console.log('reload', endSearch);
      document.location.search = endSearch;
    }
  }


</script>