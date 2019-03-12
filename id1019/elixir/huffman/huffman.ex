# huffman.ex
defmodule Huffman do
  def test(sample) do
    tree = tree(sample)
    trav = traverse(tree,[])
    encoded = encode(sample, trav)
  end

  # Creates a huffman-tree of the given sample
  def tree(sample) do
    huffman(prioq(sample))
  end

  # Creates a huffman-tree of the given priority queue
  def huffman([{elem, _}]) do elem end
  def huffman([{c1, f1}, {c2, f2} | t]) do
    node = {{c1, c2}, f1 + f2}
    huffman(insert(node, t))
  end

  # Inserts an {char, frequency}-element in the list (keeps the list sorted by frequencies)
  def insert(elem, []) do
    [elem]
  end
  def insert({c1, f1}, [{c2, f2} | t]) do
    cond do
      f1 <= f2 ->
        [{c1, f1}] ++ [{c2, f2} | t]
      f1 > f2 ->
        [{c2, f2}] ++ insert({c1, f1}, t)
    end
  end

  # Traverses the given tree, creating a table with the chars and their respective path
  def traverse(tree) do
    traverse(tree, [])
  end
  def traverse({l, r}, res) do
    left = traverse(l, res ++ [0])
    right = traverse(r, res ++ [1])
    left ++ right
  end
  def traverse(e, res) do
    [{e, res}]
  end

  # Encodes the given sample using the given table
  def encode([], _) do [] end
  def encode([char | rest], table) do
    {_, code} = List.keyfind(table, char, 0)
    code ++ encode(rest, table)
  end

  # Decodes the given sequence using the given table
  def decode([], _) do
    []
  end
  def decode(seq, table) do
    {char, rest} = decode_char(seq, 1, table)
    [char | decode(rest, table)]
  end
  def decode_char(seq, n, table) do
    {code, rest} = Enum.split(seq, n)
    case List.keyfind(table, code, 1) do
      {char, _} ->
        {char, rest}
      nil ->
        decode_char(seq, n+1, table)
    end
  end

  # Creates a priority queue by sorting the list by frequency
  def prioq(sample) do
    freq(sample) |> List.keysort(1)
  end

  # Calculates the frequency of each letter in the sample and puts the frequencies in List
  def freq(sample) do
    freq(sample, %{})
  end
  def freq([], freq) do
    Map.to_list(freq)
  end
  def freq([char | rest], freq) do
    freq(rest, Map.update(freq, char, 1, &(&1 + 1)))
  end
end
