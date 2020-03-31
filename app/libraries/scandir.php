<?php

// Scan a directory and clean up junk files.
function scandir_clean($path, $blacklist = []) {

  // Expand on blacklist.
  $blacklist = array_merge($blacklist, [
    '.',
    '..',
    '.DS_Store'
  ]);

  // Scan directory for contents.
  return array_values(array_filter(scandir($path), function($library) use ($blacklist) {

    // Ignore blacklisted files.
    return !in_array($library, $blacklist);

  }));

}

?>
