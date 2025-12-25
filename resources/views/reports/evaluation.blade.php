<!DOCTYPE html>
<html>

<body>
  <h2>Evaluation Report</h2>
  <p>Project: {{ $project }}</p>
  <table border="1" width="100%">
    <tr>
      <th>Criteria</th>
      <th>Score</th>
    </tr>
    @foreach($criteria as $c)
    <tr>
      <td>{{ $c['name'] }}</td>
      <td>{{ $c['score'] }}</td>
    </tr>
    @endforeach
  </table>
</body>

</html>