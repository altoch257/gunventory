using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using Microsoft.AspNetCore.Mvc.Rendering;
using Gunventory.Data;
using Gunventory.Models;
using Microsoft.AspNetCore.Authorization;
using System.ComponentModel.DataAnnotations;

namespace Gunventory.Pages;

[Authorize]
public class AddMalfunctionModel : PageModel
{
    private readonly GunventoryContext _context;

    public AddMalfunctionModel(GunventoryContext context)
    {
        _context = context;
    }

    [BindProperty]
    public InputModel Input { get; set; } = new();

    public SelectList Firearms { get; set; } = default!;
    public SelectList MalfunctionTypes { get; set; } = default!;
    public SelectList Ammunitions { get; set; } = default!;

    public class InputModel
    {
        [Required]
        public int FirearmId { get; set; }

        [Required]
        public int MalfunctionTypeId { get; set; }

        [Required]
        public int AmmoId { get; set; }

        [DataType(DataType.Date)]
        public DateTime? MalfunctionDate { get; set; } = DateTime.Now;

        [MaxLength(255)]
        public string? Details { get; set; }
    }

    public void OnGet()
    {
        Firearms = new SelectList(_context.Firearms.Where(f => f.Status == "A"), "Id", "Model");
        MalfunctionTypes = new SelectList(_context.MalfunctionTypes.Where(m => m.Status == "A"), "Id", "Name");
        Ammunitions = new SelectList(_context.Ammunitions.Where(a => a.Status == "A"), "Id", "Manufacturer");
    }

    public async Task<IActionResult> OnPostAsync()
    {
        if (!ModelState.IsValid)
        {
            Firearms = new SelectList(_context.Firearms.Where(f => f.Status == "A"), "Id", "Model");
            MalfunctionTypes = new SelectList(_context.MalfunctionTypes.Where(m => m.Status == "A"), "Id", "Name");
            Ammunitions = new SelectList(_context.Ammunitions.Where(a => a.Status == "A"), "Id", "Manufacturer");
            return Page();
        }

        var malfunction = new Malfunction
        {
            FirearmId = Input.FirearmId,
            MalfunctionTypeId = Input.MalfunctionTypeId,
            AmmoId = Input.AmmoId,
            MalfunctionDate = Input.MalfunctionDate,
            Details = Input.Details,
            Status = "A",
            STimestamp = DateTime.Now
        };

        _context.Malfunctions.Add(malfunction);
        await _context.SaveChangesAsync();

        return RedirectToPage("/FirearmDetails", new { id = Input.FirearmId });
    }
}
