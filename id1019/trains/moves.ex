# moves.ex
defmodule Moves do
  def single({:one, n}, {main, one, two}) do
    cond do
      n > 0 ->
        {ListP.take(main, length(main) - n), ListP.append(one, ListP.drop(main, length(main) - n)), two}
      n < 0 ->
        {ListP.append(main, ListP.take(one, Kernel.abs(n))), ListP.drop(one, Kernel.abs(n)), two}
    end
  end
  def single({:two, n}, {main, one, two}) do
    cond do
      n > 0 ->
        {ListP.take(main, length(main) - n), one, ListP.append(two, ListP.drop(main, length(main) - n))}
      n < 0 ->
        {ListP.append(main, ListP.take(two, Kernel.abs(n))), one, ListP.drop(two, Kernel.abs(n))}
    end
  end

  def move([], state) do state end
  def move([h|t], state) do
    [state] ++ move(t, single(h, state))
  end
end
